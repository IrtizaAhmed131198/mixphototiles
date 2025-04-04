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
        Schema::table('custom_color', function (Blueprint $table) {
            $table->string('before_color_code')->after('name');
            $table->string('after_color_code')->after('before_color_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('custom_color', function (Blueprint $table) {
            $table->dropColumn('before_color_code');
            $table->dropColumn('after_color_code');
        });
    }
};
