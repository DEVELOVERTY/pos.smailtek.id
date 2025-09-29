<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // Composite index untuk query utama laporan penjualan
            $table->index(['type', 'status', 'deleted_at', 'created_at'], 'idx_transactions_sell_report');
            
            // Index untuk filter store
            $table->index(['store_id', 'type'], 'idx_transactions_store_type');
            
            // Index untuk filter customer
            $table->index(['customer_id', 'type'], 'idx_transactions_customer_type');
            
            // Index untuk filter created_by
            $table->index(['created_by', 'type'], 'idx_transactions_created_by_type');
            
            // Index untuk filter payment_status
            $table->index(['payment_status', 'type'], 'idx_transactions_payment_type');
        });

        Schema::table('transaction_payments', function (Blueprint $table) {
            // Index untuk join dengan transactions
            $table->index(['transaction_id', 'amount'], 'idx_transaction_payments_amount');
        });

        Schema::table('sells', function (Blueprint $table) {
            // Index untuk menghitung qty dan profit
            $table->index(['transaction_id', 'qty', 'qty_return'], 'idx_sells_transaction_qty');
        });

        Schema::table('sell_purchases', function (Blueprint $table) {
            // Index untuk join profit calculation
            $table->index(['sell_id', 'purchase_id'], 'idx_sell_purchases_join');
        });

        Schema::table('purchases', function (Blueprint $table) {
            // Index untuk profit calculation
            $table->index(['id', 'purchase_price'], 'idx_purchases_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex('idx_transactions_sell_report');
            $table->dropIndex('idx_transactions_store_type');
            $table->dropIndex('idx_transactions_customer_type');
            $table->dropIndex('idx_transactions_created_by_type');
            $table->dropIndex('idx_transactions_payment_type');
        });

        Schema::table('transaction_payments', function (Blueprint $table) {
            $table->dropIndex('idx_transaction_payments_amount');
        });

        Schema::table('sells', function (Blueprint $table) {
            $table->dropIndex('idx_sells_transaction_qty');
        });

        Schema::table('sell_purchases', function (Blueprint $table) {
            $table->dropIndex('idx_sell_purchases_join');
        });

        Schema::table('purchases', function (Blueprint $table) {
            $table->dropIndex('idx_purchases_price');
        });
    }
};
