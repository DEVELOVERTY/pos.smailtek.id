<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVariationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->char('sku',30);
            $table->unsignedBigInteger('variation_value_id')->nullable();
            $table->char('price_inc_tax',100);
            $table->string('name')->default("no-name");
            $table->char('selling_price',100);
            $table->char('purchase_price',100);
            $table->char('margin',100);
            $table->string('image')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('variation_value_id')->references('id')->on('variation_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('variations');
    }
}
