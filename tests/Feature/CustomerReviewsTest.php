<?php

namespace Tests\Feature;

use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CustomerReviewsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost', 'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'session.driver' => 'array', 'cache.default' => 'array']);
        app('url')->forceRootUrl('http://localhost');
        DB::purge('sqlite');
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('review');
            $table->integer('rating');
            foreach (['designation', 'avatar', 'product_image'] as $column) $table->string($column)->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('status')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
        (require database_path('migrations/2026_11_17_000001_add_customer_submission_fields_to_testimonials.php'))->up();
        Schema::create('settings', function (Blueprint $table) {
            $table->id(); $table->string('name'); $table->text('value')->nullable();
        });
    }

    private function submission(array $overrides = []): array
    {
        return array_merge(['name' => 'Priya', 'email' => 'private@example.com', 'rating' => 5, 'title' => 'Lovely frames', 'review' => 'Our family photos look beautiful on the wall.', 'consent' => '1'], $overrides);
    }

    private function review(bool $approved = true, int $rating = 5): Testimonial
    {
        $this->post('/reviews', $this->submission(['rating' => $rating]))->assertRedirect();
        $review = Testimonial::latest('id')->firstOrFail();
        $review->status = $approved;
        $review->save();
        return $review;
    }

    private function admin(): User
    {
        $user = new User();
        $user->id = 1;
        $user->role = 'admin';
        return $user;
    }

    public function test_guest_submission_is_pending_and_cannot_set_approval_or_featured_status(): void
    {
        $this->post('/reviews', $this->submission(['status' => 1, 'is_featured' => 1, 'is_customer_submission' => 0]))
            ->assertRedirect(route('reviews.index').'#write-review')->assertSessionHas('review_submitted', true);
        $review = Testimonial::firstOrFail();
        $this->assertFalse($review->status);
        $this->assertFalse($review->is_featured);
        $this->assertTrue($review->is_customer_submission);
        $this->assertSame('private@example.com', $review->email);
    }

    public function test_review_requires_valid_rating_email_content_and_consent(): void
    {
        $this->post('/reviews', $this->submission(['rating' => 6, 'email' => 'invalid', 'review' => 'short', 'consent' => '0']))
            ->assertSessionHasErrors(['rating', 'email', 'review', 'consent']);
        $this->assertSame(0, Testimonial::count());
    }

    public function test_public_page_shows_only_approved_customer_reviews_and_shared_layout(): void
    {
        $this->review(false);
        Testimonial::create(['name' => 'Old sample', 'review' => 'Legacy sample content.', 'rating' => 5, 'status' => true]);
        $this->get('/reviews')->assertOk()->assertDontSee('Legacy sample content.')->assertDontSee('Lovely frames')->assertSee('Your story could be the first.');
        $review = Testimonial::where('is_customer_submission', true)->firstOrFail();
        $review->status = true; $review->save();
        $this->get('/reviews')->assertOk()->assertSee('Lovely frames')->assertDontSee('private@example.com')
            ->assertSee('scrollheader', false)->assertSee('Footer_footer', false)
            ->assertSee(route('collections'), false)->assertSee(route('design'), false);
    }

    public function test_rating_filter_and_pagination_work_on_server(): void
    {
        $this->review(true, 4);
        $five = $this->review(true, 5);
        for ($i = 0; $i < 6; $i++) {
            $copy = $five->replicate(); $copy->save();
        }
        $this->get('/reviews?rating=5')->assertOk()->assertViewHas('reviews', fn ($reviews) => $reviews->total() === 7 && $reviews->count() === 6);
        $this->get('/reviews?rating=5&page=2')->assertOk()->assertViewHas('reviews', fn ($reviews) => $reviews->count() === 1);
        $this->get('/reviews?rating=4')->assertOk()->assertViewHas('reviews', fn ($reviews) => $reviews->total() === 1);
    }

    public function test_admin_can_approve_edit_and_hide_a_customer_review(): void
    {
        $review = $this->review(false);
        $this->actingAs($this->admin());
        $payload = ['name' => $review->name, 'review' => $review->review, 'rating' => 5, 'status' => 1, 'title' => 'Approved title'];
        $this->postJson('/admin/testimonials/update/'.$review->id, $payload)->assertOk()->assertJson(['success' => true]);
        $this->get('/reviews')->assertOk()->assertSee('Approved title');
        $this->postJson('/admin/testimonials/update/'.$review->id, array_merge($payload, ['status' => 0]))->assertOk();
        $this->get('/reviews')->assertOk()->assertDontSee('Approved title');
    }

    public function test_non_admins_cannot_read_private_submission_or_approve_it(): void
    {
        $review = $this->review(false);
        $this->getJson('/admin/testimonials/edit/'.$review->id)->assertForbidden();
        $this->getJson('/admin/testimonials/data')->assertForbidden();
        $this->postJson('/admin/testimonials/update/'.$review->id, ['status' => 1])->assertForbidden();
        $customer = $this->admin(); $customer->role = 'user';
        $this->actingAs($customer)->getJson('/admin/testimonials/edit/'.$review->id)->assertForbidden();
    }

    public function test_customer_text_is_escaped_on_public_page(): void
    {
        $review = $this->review();
        $review->name = '<script>alert(1)</script>'; $review->save();
        $this->get('/reviews')->assertOk()->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_submission_is_rate_limited(): void
    {
        for ($i = 0; $i < 5; $i++) $this->post('/reviews', $this->submission())->assertRedirect();
        $this->post('/reviews', $this->submission())->assertStatus(429);
        $this->assertSame(5, Testimonial::count());
    }
}
