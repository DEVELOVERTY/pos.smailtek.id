<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id')->index();
            $table->unsignedBigInteger('store_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('variation_id')->index();
            $table->integer('qty');
            $table->integer('qty_return');
            $table->string('unit_price');
            $table->string('unit_price_before_disc');
            $table->string('item_tax')->nullable();
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->string('disc_type')->nullable();
            $table->string('disc_amount')->nullable();
            $table->softDeletes();
            $table->timestamps();

            //$table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('variation_id')->references('id')->on('variations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sells');
    }
}
