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
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->string('email')->nullable()->after('user_id'); // Corrected this line
            $table->boolean('default_address')->default(false)->after('alt_phone'); // Corrected this line
            $table->dropColumn('country');
            $table->string('country')->nullable()->after('pin_code'); // Corrected the order of the columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipping_addresses', function (Blueprint $table) {
            $table->dropColumn('default_address');
            $table->dropColumn('email');
            $table->dropColumn('country');
            $table->string('country')->nullable()->after('pin_code'); // Re-added the country column
        });
    }
};
