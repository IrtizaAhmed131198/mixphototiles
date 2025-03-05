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
        Schema::table('session_images', function (Blueprint $table) {
            $table->boolean('crop')->default(0)->after('frame_configuration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('session_images', function (Blueprint $table) {
            $table->dropColumn('crop');
        });
    }
};
