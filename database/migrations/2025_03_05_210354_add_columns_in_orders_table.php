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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('coupon')->nullable()->after('payment_method');
            $table->string('discount')->nullable()->after('coupon');
            $table->string('shipping')->nullable()->after('discount');
            $table->string('gift')->nullable()->after('shipping');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('coupon');
            $table->dropColumn('discount');
            $table->dropColumn('shipping');
            $table->dropColumn('gift');
        });
    }
};
