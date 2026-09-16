<?php

namespace Tests\Feature;

use App\Http\Controllers\RazorpayController;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\User;
use App\Services\CheckoutService;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use Mockery;
use Tests\TestCase;

class CheckoutSafetyTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'cache.default' => 'array']);
        DB::purge('sqlite');
        Mail::fake();
        foreach (['users', 'products', 'orders', 'order_items', 'addresses', 'shipping_addresses', 'cities', 'states', 'settings', 'coupon'] as $name) {
            Schema::create($name, function (Blueprint $table) use ($name) {
                $table->id();
                $table->timestamps();
                $columns = match ($name) {
                    'users' => ['name', 'email', 'password', 'phone', 'role', 'status'],
                    'products' => ['name', 'price', 'status'],
                    'orders' => ['user_id', 'status', 'payment_method', 'total_amount', 'coupon', 'discount', 'shipping', 'gift', 'payment_id'],
                    'order_items' => ['order_id', 'product_id', 'quantity', 'price'],
                    'addresses' => ['order_id', 'user_id', 'full_name', 'email', 'phone_number', 'pincode', 'address_line1', 'address_line2', 'city', 'alternate_phone_number'],
                    'shipping_addresses' => ['user_id', 'email', 'recipient_name', 'phone', 'pin_code', 'address_line1', 'address_line2', 'city', 'state', 'alt_phone', 'default_address'],
                    'cities' => ['name', 'state_id'],
                    'states' => ['name'],
                    'settings' => ['name', 'value'],
                    'coupon' => ['code', 'discount_amount', 'status'],
                };
                foreach ($columns as $column) {
                    $table->string($column)->nullable();
                }
            });
        }
        (require database_path('migrations/2026_09_16_000001_add_checkout_tracking_to_orders.php'))->up();
        DB::table('states')->insert(['id' => 1, 'name' => 'State']);
        DB::table('cities')->insert(['id' => 1, 'name' => 'City', 'state_id' => 1]);
        DB::table('products')->insert(['id' => 1, 'name' => 'Frame', 'price' => '1.00', 'status' => '1']);
        $this->actingAs(User::create(['name' => 'Customer', 'email' => 'customer@example.com', 'password' => 'password', 'role' => 'user', 'status' => 1]));
    }

    private function address(): array
    {
        return ['full_name' => 'Customer', 'email' => 'customer@example.com', 'phone_number' => '9999999999', 'pincode' => '110001', 'address_line1' => 'Test address', 'city' => 1, 'state' => 1];
    }

    private function prepare(): Order
    {
        return app(CheckoutService::class)->prepare([['product_id' => 1, 'quantity' => 1, 'price' => 999]], $this->address(), auth()->user());
    }

    public function test_complete_pending_order_is_saved_using_database_price(): void
    {
        $order = $this->prepare();
        $this->assertSame('pending', $order->status);
        $this->assertEquals(1, $order->total_amount);
        $this->assertNull($order->payment_id);
        $this->assertDatabaseHas('addresses', ['order_id' => $order->id]);
        $this->assertDatabaseHas('order_items', ['order_id' => $order->id, 'price' => '1.00']);
        Mail::assertNothingSent();
    }

    public function test_item_failure_rolls_back_entire_order(): void
    {
        OrderItems::saving(function () {
            throw new \RuntimeException('Simulated item failure');
        });
        try {
            $this->prepare();
            $this->fail('The simulated database failure must propagate.');
        } catch (\RuntimeException $e) {
            $this->assertSame('Simulated item failure', $e->getMessage());
        } finally {
            OrderItems::flushEventListeners();
        }
        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('addresses', 0);
        $this->assertDatabaseCount('order_items', 0);
    }

    public function test_invalid_address_never_calls_razorpay(): void
    {
        $controller = Mockery::mock(RazorpayController::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $controller->shouldNotReceive('api');
        $request = Request::create('/razorpay/create-order', 'POST');
        $request->setLaravelSession(app('session.store'));
        $request->session()->put('cart', [['product_id' => 1, 'quantity' => 1]]);
        $response = $controller->createOrder($request, app(CheckoutService::class));
        $this->assertSame(422, $response->getStatusCode());
        $this->assertDatabaseCount('orders', 0);
    }

    public function test_captured_payment_is_idempotent_and_preserves_later_order_status(): void
    {
        $order = $this->prepare();
        $order->razorpay_order_id = 'order_test';
        $order->save();
        $payment = ['id' => 'pay_test', 'order_id' => 'order_test', 'currency' => 'INR', 'amount' => 100, 'status' => 'captured', 'method' => 'upi'];
        $service = app(CheckoutService::class);
        $order = $service->recordPayment($order, $payment);
        $this->assertSame('ordered', $order->status);
        $this->assertNotNull($order->paid_at);
        $order->status = 'shipped';
        $order->save();
        $order = $service->recordPayment($order, $payment);
        $this->assertSame('shipped', $order->status);
        Mail::assertSent(\App\Mail\OrderPlacedUserMail::class, 1);
    }

    public function test_wrong_amount_is_rejected_without_marking_order_paid(): void
    {
        $order = $this->prepare();
        $order->razorpay_order_id = 'order_test';
        $order->save();
        try {
            app(CheckoutService::class)->recordPayment($order, ['id' => 'pay_test', 'order_id' => 'order_test', 'currency' => 'INR', 'amount' => 200, 'status' => 'captured']);
            $this->fail('Incorrect payment amount must be rejected.');
        } catch (ValidationException $e) {
            $this->assertNull($order->fresh()->paid_at);
            $this->assertNull($order->fresh()->payment_id);
        }
    }

    public function test_unsigned_webhook_is_rejected(): void
    {
        config(['services.razorpay.webhook_secret' => 'test_secret']);
        $response = app(RazorpayController::class)->webhook(Request::create('/razorpay/webhook', 'POST', [], [], [], [], '{}'), app(CheckoutService::class));
        $this->assertSame(401, $response->getStatusCode());
    }

    public function test_repeated_checkout_reuses_the_saved_order_and_remote_order(): void
    {
        $remote = Mockery::mock(\Razorpay\Api\Order::class);
        $remote->shouldReceive('create')->once()->andReturnUsing(function ($data) {
            $this->assertDatabaseCount('orders', 1);
            $this->assertDatabaseCount('addresses', 1);
            $this->assertDatabaseCount('order_items', 1);
            $this->assertSame(100, $data['amount']);

            return ['id' => 'order_test'];
        });
        $api = new CheckoutFakeApi(null, null);
        $api->resources['order'] = $remote;
        $controller = Mockery::mock(RazorpayController::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('api')->once()->andReturn($api);
        $request = Request::create('/razorpay/create-order', 'POST');
        $request->setLaravelSession(app('session.store'));
        $request->session()->put(['cart' => [['product_id' => 1, 'quantity' => 1]], 'user_address' => $this->address()]);
        $first = $controller->createOrder($request, app(CheckoutService::class));
        $second = $controller->createOrder($request, app(CheckoutService::class));
        $this->assertSame(200, $first->getStatusCode());
        $this->assertSame($first->getData()->id, $second->getData()->id);
        $this->assertDatabaseCount('orders', 1);
    }

    private function paymentController(array $authorized, bool $expectCapture): RazorpayController
    {
        $payment = Mockery::mock(\Razorpay\Api\Payment::class)->makePartial();
        $payment->fill($authorized);
        if ($expectCapture) {
            $captured = new \Razorpay\Api\Payment;
            $captured->fill(array_merge($authorized, ['status' => 'captured']));
            $payment->shouldReceive('capture')->once()->andReturnUsing(function ($data) use ($captured) {
                $this->assertDatabaseHas('orders', ['payment_id' => 'pay_test', 'status' => 'pending']);
                $this->assertDatabaseCount('addresses', 1);
                $this->assertDatabaseCount('order_items', 1);
                $this->assertSame(100, $data['amount']);

                return $captured;
            });
        } else {
            $payment->shouldNotReceive('capture');
        }
        $resource = Mockery::mock(\Razorpay\Api\Payment::class);
        $resource->shouldReceive('fetch')->with('pay_test')->once()->andReturn($payment);
        $api = new CheckoutFakeApi(null, null);
        $api->resources['payment'] = $resource;
        $controller = Mockery::mock(RazorpayController::class)->makePartial()->shouldAllowMockingProtectedMethods();
        $controller->shouldReceive('api')->once()->andReturn($api);

        return $controller;
    }

    public function test_capture_happens_only_after_order_details_and_payment_link_are_committed(): void
    {
        $order = $this->prepare();
        $order->razorpay_order_id = 'order_test';
        $order->save();
        $controller = $this->paymentController(['id' => 'pay_test', 'order_id' => 'order_test', 'currency' => 'INR', 'amount' => 100, 'status' => 'authorized', 'method' => 'upi'], true);
        $method = new \ReflectionMethod(RazorpayController::class, 'reconcile');
        $result = $method->invoke($controller, $order, 'pay_test', app(CheckoutService::class));
        $this->assertNotNull($result->paid_at);
        $this->assertSame('ordered', $result->status);
    }

    public function test_database_error_before_capture_does_not_call_capture(): void
    {
        $order = $this->prepare();
        $order->razorpay_order_id = 'order_test';
        $order->save();
        $controller = $this->paymentController(['id' => 'pay_test', 'order_id' => 'order_test', 'currency' => 'INR', 'amount' => 100, 'status' => 'authorized'], false);
        Order::saving(function () {
            throw new \RuntimeException('Simulated payment link failure');
        });
        try {
            (new \ReflectionMethod(RazorpayController::class, 'reconcile'))->invoke($controller, $order, 'pay_test', app(CheckoutService::class));
            $this->fail('Payment link save must fail.');
        } catch (\RuntimeException $e) {
            $this->assertSame('Simulated payment link failure', $e->getMessage());
        } finally {
            Order::flushEventListeners();
        }
        $this->assertNull($order->fresh()->paid_at);
    }

    public function test_signed_webhook_recovers_payment_without_a_browser_session(): void
    {
        $order = $this->prepare();
        $order->razorpay_order_id = 'order_test';
        $order->save();
        $controller = $this->paymentController(['id' => 'pay_test', 'order_id' => 'order_test', 'currency' => 'INR', 'amount' => 100, 'status' => 'captured'], false);
        config(['services.razorpay.webhook_secret' => 'test_secret']);
        $body = json_encode(['event' => 'payment.captured', 'payload' => ['payment' => ['entity' => ['id' => 'pay_test', 'order_id' => 'order_test']]]]);
        $request = Request::create('/razorpay/webhook', 'POST', [], [], [], ['CONTENT_TYPE' => 'application/json', 'HTTP_X_RAZORPAY_SIGNATURE' => hash_hmac('sha256', $body, 'test_secret')], $body);
        $response = $controller->webhook($request, app(CheckoutService::class));
        $this->assertSame(200, $response->getStatusCode());
        $this->assertNotNull($order->fresh()->paid_at);
    }

    public function test_legacy_place_order_cannot_create_an_order_from_a_payment_id(): void
    {
        $this->postJson('http://localhost/place-order', ['razorpay_payment_id' => 'pay_fake'])->assertStatus(409);
        $this->assertDatabaseCount('orders', 0);
    }
}

// An explicit API double prevents the SDK magic accessor creating real HTTP resources.
class CheckoutFakeApi extends \Razorpay\Api\Api
{
    public array $resources = [];

    public function __get($name)
    {
        if (! isset($this->resources[$name])) {
            throw new \LogicException('Unexpected external API resource: '.$name);
        }

        return $this->resources[$name];
    }
}
