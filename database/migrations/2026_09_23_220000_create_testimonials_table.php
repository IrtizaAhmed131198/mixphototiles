<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('testimonials')) {
            Schema::create('testimonials', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('review');
                $table->tinyInteger('rating')->default(5);
                $table->string('designation')->nullable();
                $table->string('avatar')->nullable();
                $table->string('product_image')->nullable();
                $table->boolean('is_featured')->default(0);
                $table->boolean('status')->default(1);
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });

            // Seed initial testimonials from client's reference
            $seedData = [
                [
                    'name' => 'Sarah K.',
                    'review' => 'The quality exceeded my expectations. Every detail feels thoughtful.',
                    'rating' => 5,
                    'designation' => 'Verified Buyer',
                    'avatar' => null,
                    'product_image' => 'uploads/testimonials/featured_frame.png',
                    'is_featured' => 1,
                    'status' => 1,
                    'sort_order' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'James L.',
                    'review' => 'Such a beautiful and minimal design. It fits perfectly in our home.',
                    'rating' => 5,
                    'designation' => 'Verified Buyer',
                    'avatar' => 'uploads/testimonials/avatar_james.png',
                    'product_image' => null,
                    'is_featured' => 0,
                    'status' => 1,
                    'sort_order' => 2,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Emily R.',
                    'review' => 'A simple idea, but such a game changer. Our photos finally feel special again.',
                    'rating' => 5,
                    'designation' => 'Verified Buyer',
                    'avatar' => 'uploads/testimonials/avatar_emily.png',
                    'product_image' => null,
                    'is_featured' => 0,
                    'status' => 1,
                    'sort_order' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Daniel M.',
                    'review' => 'Excellent build quality and super easy to use. Highly recommend!',
                    'rating' => 5,
                    'designation' => 'Verified Buyer',
                    'avatar' => 'uploads/testimonials/avatar_daniel.png',
                    'product_image' => null,
                    'is_featured' => 0,
                    'status' => 1,
                    'sort_order' => 4,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ];

            DB::table('testimonials')->insert($seedData);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};

