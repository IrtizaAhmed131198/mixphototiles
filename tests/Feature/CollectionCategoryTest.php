<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CollectionCategoryTest extends TestCase
{
    private string $uploadDirectory;

    protected function setUp(): void
    {
        parent::setUp();
        config(['app.url' => 'http://localhost', 'database.default' => 'sqlite', 'database.connections.sqlite.database' => ':memory:', 'session.driver' => 'array']);
        app('url')->forceRootUrl('http://localhost');
        DB::purge('sqlite');

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            foreach (['name', 'slug', 'description', 'price', 'indian_price', 'frame_note', 'indian_frame_note', 'discount', 'stock', 'image', 'no_coordinates_image', 'coordinates_image', 'coordinates', 'frame_config', 'status', 'type'] as $column) {
                $table->text($column)->nullable();
            }
        });
        $this->categoryMigration()->up();

        foreach (['product_images', 'session_collection', 'collection_images', 'cluster_images', 'custom_color', 'finish', 'led', 'settings'] as $name) {
            Schema::create($name, function (Blueprint $table) use ($name) {
                $table->id();
                $table->timestamps();
                $columns = match ($name) {
                    'product_images' => ['product_id', 'image_path', 'crop_image_path'],
                    'session_collection' => ['product_id', 'session_id', 'image_name', 'configuration', 'price'],
                    'collection_images' => ['collection_id', 'image', 'original_image'],
                    'settings' => ['name', 'value'],
                    default => ['status'],
                };
                foreach ($columns as $column) {
                    $table->text($column)->nullable();
                }
            });
        }
        $this->uploadDirectory = storage_path('framework/testing/collection-category-'.bin2hex(random_bytes(6)));
        $this->app->usePublicPath($this->uploadDirectory);
    }

    protected function tearDown(): void
    {
        if (isset($this->uploadDirectory) && is_dir($this->uploadDirectory)) {
            File::deleteDirectory($this->uploadDirectory);
        }
        parent::tearDown();
    }

    private function categoryMigration(): object
    {
        return require database_path('migrations/2026_11_15_000001_add_collection_category_to_products_table.php');
    }

    private function product(array $attributes = []): Product
    {
        return Product::create(array_merge([
            'name' => 'Collection', 'slug' => 'collection', 'price' => 1000,
            'indian_price' => 600, 'discount' => 10, 'status' => 1, 'type' => 'collections',
            'image' => 'test.jpg', 'no_coordinates_image' => 'test.jpg', 'coordinates_image' => 'test.jpg',
            'coordinates' => '[]', 'frame_note' => 'European note', 'indian_frame_note' => 'Indian note',
        ], $attributes));
    }

    public function test_migration_defaults_existing_records_to_frames_and_can_roll_back(): void
    {
        $this->categoryMigration()->down();
        $product = $this->product();
        $this->categoryMigration()->up();
        $this->assertSame('frames', $product->fresh()->collection_category);
        $this->categoryMigration()->down();
        $this->assertFalse(Schema::hasColumn('products', 'collection_category'));
    }

    public function test_admin_can_save_and_reopen_a_tile_category_without_losing_indian_fields(): void
    {
        $product = $this->product();
        $this->post('/frames/'.$product->id, [
            'name' => $product->name, 'slug' => $product->slug, 'price' => 1000,
            'indian_price' => 600, 'frame_note' => 'European note', 'indian_frame_note' => 'Indian note',
            'discount' => 10, 'status' => 1, 'collection_category' => 'tiles',
        ])->assertSessionHasNoErrors()->assertRedirect();

        $this->assertTrue($product->fresh()->isTileCollection());
        $this->getJson('/frames/'.$product->id.'/edit')->assertOk()->assertJson([
            'collection_category' => 'tiles', 'indian_price' => '600', 'indian_frame_note' => 'Indian note',
        ]);
    }

    public function test_invalid_category_is_rejected(): void
    {
        $product = $this->product();
        $this->postJson('/frames/'.$product->id, [
            'name' => $product->name, 'slug' => $product->slug, 'price' => 1000,
            'status' => 1, 'collection_category' => 'invalid',
        ])->assertUnprocessable()->assertJsonValidationErrors('collection_category');
        $this->assertFalse($product->fresh()->isTileCollection());
    }

    public function test_admin_can_create_a_tile_collection(): void
    {
        $this->post('/frames/store', [
            'name' => 'New tiles', 'slug' => 'new-tiles', 'price' => 1000,
            'discount' => 0, 'status' => 1, 'collection_category' => 'tiles',
            'main_image' => UploadedFile::fake()->image('main.jpg'),
            'no_coordinates_image' => UploadedFile::fake()->image('room.jpg'),
            'coordinates_image' => UploadedFile::fake()->image('layout.jpg'),
        ])->assertSessionHasNoErrors()->assertRedirect();
        $this->assertTrue(Product::where('slug', 'new-tiles')->firstOrFail()->isTileCollection());
    }

    public function test_cards_use_european_prices_for_tiles_and_indian_prices_for_frames(): void
    {
        foreach (['frames' => 540, 'tiles' => 900] as $category => $expectedPrice) {
            $product = $this->product(['collection_category' => $category]);
            $html = view('partials.product_card', ['products' => collect([$product])])->render();
            $this->assertStringContainsString('₹ '.$expectedPrice, $html);
            $this->assertStringContainsString($category === 'tiles' ? 'European note' : 'Indian note', $html);
            $this->assertStringNotContainsString($category === 'tiles' ? 'Indian note' : 'European note', $html);
        }
    }

    public function test_tile_detail_omits_type_selector_and_starts_with_european_price(): void
    {
        $product = $this->product(['collection_category' => 'tiles']);
        $this->get('/collection/'.$product->slug)
            ->assertOk()
            ->assertDontSee('id="col-btn-indian"', false)
            ->assertDontSee('id="col-btn-european"', false)
            ->assertSee('const isTileCollection = true;', false)
            ->assertSee('data-base="900"', false)
            ->assertSee('European note')
            ->assertDontSee('Indian note');
    }

    public function test_frame_detail_keeps_both_options_and_indian_default(): void
    {
        $product = $this->product();
        $this->get('/collection/'.$product->slug)
            ->assertOk()
            ->assertSee('id="col-btn-indian"', false)
            ->assertSee('id="col-btn-european"', false)
            ->assertSee('data-base="540"', false)
            ->assertSee('Indian note');
    }

    public function test_cart_preserves_tile_category_and_forces_european_configuration(): void
    {
        $product = $this->product(['collection_category' => 'tiles']);
        $this->post('/add-to-cart-collection', [
            'product_id' => $product->id, 'slug' => $product->slug, 'name' => $product->name,
            'price' => 900, 'image' => UploadedFile::fake()->create('preview.png', 1, 'image/png'),
            'configuration' => json_encode(['frame_type' => ['type' => 'indian', 'name' => 'Indian Frames'], 'color' => ['name' => 'Black']]),
            'colImageArr' => '[]', 'colImageOrignalArr' => '[]',
        ])->assertOk()->assertJson(['success' => true]);

        $saved = Product::where('type', 'manual_collection')->firstOrFail();
        $this->assertTrue($saved->isTileCollection());
        $configuration = json_decode($saved->frame_config, true);
        $this->assertSame('european', $configuration['frame_type']['type']);
        $this->assertSame('Black', $configuration['color']['name']);
        $storedConfiguration = json_decode(DB::table('session_collection')->value('configuration'), true);
        $this->assertSame('european', $storedConfiguration['frame_type']['type']);

        $imageName = basename(DB::table('session_collection')->value('image_name'));
        $this->get('/collection/'.$saved->slug.'?image_name='.$imageName)
            ->assertOk()
            ->assertDontSee('id="col-btn-indian"', false)
            ->assertViewHas('config', fn ($config) => $config->frame_type->type === 'european');
    }
}
