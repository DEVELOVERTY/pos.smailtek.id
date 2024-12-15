<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('store_id')->index();
            $table->foreign('store_id')->references('id')->on('stores');
            $table->enum('type', ['purchase', 'sell','purchase_return','stock_transfer','stock_adjustment','open_stock','sales_return']);
            $table->enum('status', ['received','pending','ordered','hold','final','due','transit','complete'])->nullable();
            $table->enum('payment_status', ['paid', 'due'])->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable()->index();
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->string('invoice_no')->nullable();
            $table->string('ref_no')->nullable();
            $table->dateTime('transaction_date');
            $table->decimal('total_before_tax', 22, 4)->default(0);
            $table->unsignedBigInteger('tax_id')->unsigned()->nullable();
            $table->foreign('tax_id')->references('id')->on('taxrates');
            $table->decimal('tax_amount', 22, 4)->default(0);
            $table->enum('discount_type', ['fixed', 'percent'])->nullable();
            $table->decimal('discount_amount', 22, 4)->default(0);
            $table->text('shipping_details')->nullable();
            $table->decimal('shipping_charges', 22, 4)->default(0);
            $table->decimal('other_charges',22,4)->default(0);
            $table->text('additional_notes')->nullable();
            $table->text('staff_note')->nullable();
            $table->unsignedBigInteger('return_parent')->nullable();
            $table->decimal('final_total', 22, 4)->default(0);
            $table->decimal('total_amount_recovered',22,4)->default(0);
            $table->string('adjustment_type',50)->nullable();
            $table->unsignedBigInteger('created_by')->unsigned();
            $table->foreign('created_by')->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
