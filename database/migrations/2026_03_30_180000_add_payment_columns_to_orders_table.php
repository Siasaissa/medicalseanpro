<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'payment_gateway')) {
                $table->string('payment_gateway')->nullable()->after('payment_method');
            }

            if (!Schema::hasColumn('orders', 'payment_reference')) {
                $table->string('payment_reference')->nullable()->after('status');
            }

            if (!Schema::hasColumn('orders', 'transaction_id')) {
                $table->string('transaction_id')->nullable()->after('payment_reference');
            }

            if (!Schema::hasColumn('orders', 'payment_response')) {
                $table->longText('payment_response')->nullable()->after('transaction_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            foreach (['payment_gateway', 'payment_reference', 'transaction_id', 'payment_response'] as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
