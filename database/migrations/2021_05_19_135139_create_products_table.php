<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('image')->default('uploads/image.jpg');
            $table->string('name',100);
            $table->string('sku',100);
            $table->string('type',50)->index();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('brand_id')->index();
            $table->unsignedBigInteger('unit_id')->index();
            // $table->unsignedBigInteger('tax_id')->index();
            // $table->char('tax_method',50);
            $table->char('alert_quantity',50)->default(0);
            $table->char('barcode_type',50);
            $table->string('weight')->nullable();
            $table->string('custom_field1')->nullable();
            $table->string('custom_field2')->nullable();
            $table->string('custom_field3')->nullable();
            $table->string('custom_field4')->nullable();
            $table->longText('description')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('unit_id')->references('id')->on('units');
            // $table->foreign('tax_id')->references('id')->on('taxrates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
