<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transaction_id')->index();
            $table->unsignedBigInteger('store_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('variation_id')->index();
            $table->float('quantity');
            $table->decimal('discount_percent',22,4)->default(0);
            $table->decimal('without_discount',22,4);
            $table->decimal('purchase_price',22,4);
            $table->decimal('purchase_price_inc_tax',22,4)->default(0);
            $table->decimal('item_tax',22,4)->comment("Tax for one quantity");
            $table->integer('tax_id')->index()->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
