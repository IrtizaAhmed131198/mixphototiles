<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::table('sizes')->where('frame_type', 'luxury_tiles')->exists()) {
            return;
        }

        $source = DB::table('sizes')->where('frame_type', 'european')->where('status', 1)->orderBy('id')->first();

        DB::table('sizes')->insert([
            'label' => '8.4" X 8.4"',
            'price' => $source->price ?? 489,
            'image' => $source->image ?? null,
            'status' => 1,
            'frame_type' => 'luxury_tiles',
            'width' => $source->width ?? '280',
            'height' => $source->height ?? '280',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('sizes')->where('frame_type', 'luxury_tiles')->delete();
    }
};