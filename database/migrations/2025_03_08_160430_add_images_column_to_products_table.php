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
        Schema::table('products', function (Blueprint $table) {
            $table->string('no_coordinates_image')->nullable()->after('image');
            $table->string('coordinates_image')->nullable()->after('no_coordinates_image');
            $table->json('coordinates')->nullable()->after('coordinates_image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('no_coordinates_image');
            $table->dropColumn('coordinates_image');
            $table->dropColumn('coordinates');
        });
    }
};
