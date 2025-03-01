<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('temp_product', function (Blueprint $table) {
            $table->id();
            $table->string('design')->nullable();
            $table->string('display_text')->nullable();
            $table->string('color_name')->nullable();
            $table->string('img_src')->nullable();
            $table->string('shadow_class')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();
            $table->string('max_width')->nullable();
            $table->decimal('frame_price', 8, 2)->default(0);
            $table->string('frame_size_text')->nullable();
            $table->decimal('finish_price', 8, 2)->default(0);
            $table->string('frame_finish_text')->nullable();
            $table->decimal('led_price', 8, 2)->default(0);
            $table->string('led_value')->nullable();
            $table->string('framehang_text')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_product');
    }
};
