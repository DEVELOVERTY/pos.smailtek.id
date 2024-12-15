<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id')->index(); 
            $table->unsignedBigInteger('currency_id')->index();

            $table->string('name');
            $table->string('code');
            $table->string('email');
            $table->string('phone');
            $table->string('zip_code');
            $table->text('address');
            $table->integer('after_sell')->default(3);
            $table->string('tax')->default(0);
            $table->string('zakat')->default(2.5);
            $table->text('footer_text')->nullable();
            $table->integer('sound')->default(1);
            $table->string('long')->nullable();
            $table->string('lang')->nullable();
            $table->integer('currency_position')->default(1);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('currency_id')->references('id')->on('cuurencies');
            $table->foreign('country_id')->references('id')->on('countries'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stores');
    }
}
