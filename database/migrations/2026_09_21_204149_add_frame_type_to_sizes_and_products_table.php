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
        if (Schema::hasTable('sizes')) {
            Schema::table('sizes', function (Blueprint $table) {
                if (!Schema::hasColumn('sizes', 'frame_type')) {
                    $table->string('frame_type')->default('european')->after('status');
                }
            });

            // Set all existing sizes to european
            DB::table('sizes')->whereNull('frame_type')->orWhere('frame_type', '')->update(['frame_type' => 'european']);

            // Insert default Indian sizes if not present
            $indianSizes = [
                ['label' => '6" X 8"', 'price' => 299.00, 'width' => '280', 'height' => '340', 'status' => '1', 'frame_type' => 'indian', 'image' => 'uploads/size_images/indian_size_6x8.png'],
                ['label' => '8" X 12"', 'price' => 399.00, 'width' => '280', 'height' => '380', 'status' => '1', 'frame_type' => 'indian', 'image' => 'uploads/size_images/indian_size_8x12.png'],
                ['label' => '12" X 15"', 'price' => 649.00, 'width' => '340', 'height' => '420', 'status' => '1', 'frame_type' => 'indian', 'image' => 'uploads/size_images/indian_size_12x15.png'],
            ];

            foreach ($indianSizes as $size) {
                $exists = DB::table('sizes')->where('label', $size['label'])->where('frame_type', 'indian')->exists();
                if (!$exists) {
                    DB::table('sizes')->insert(array_merge($size, [
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]));
                }
            }
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (!Schema::hasColumn('products', 'indian_price')) {
                    $table->decimal('indian_price', 10, 2)->nullable()->after('price');
                }
                if (!Schema::hasColumn('products', 'indian_frame_note')) {
                    $table->string('indian_frame_note')->nullable()->after('frame_note');
                }
            });
        }

        if (Schema::hasTable('settings')) {
            // Update European floor price to 489
            DB::table('settings')->where('name', 'floor_price')->update(['value' => '489']);

            // Add indian_floor_price = 295
            $hasIndianFloor = DB::table('settings')->where('name', 'indian_floor_price')->exists();
            if (!$hasIndianFloor) {
                DB::table('settings')->insert([
                    'name' => 'indian_floor_price',
                    'value' => '295',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('sizes')) {
            Schema::table('sizes', function (Blueprint $table) {
                if (Schema::hasColumn('sizes', 'frame_type')) {
                    $table->dropColumn('frame_type');
                }
            });
            DB::table('sizes')->where('frame_type', 'indian')->delete();
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $table) {
                if (Schema::hasColumn('products', 'indian_price')) {
                    $table->dropColumn('indian_price');
                }
                if (Schema::hasColumn('products', 'indian_frame_note')) {
                    $table->dropColumn('indian_frame_note');
                }
            });
        }

        if (Schema::hasTable('settings')) {
            DB::table('settings')->where('name', 'indian_floor_price')->delete();
        }
    }
};
