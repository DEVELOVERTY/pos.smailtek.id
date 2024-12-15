<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPurchaseQuantity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->string('qty_sold')->after('quantity')->nullable();
            $table->string('qty_adjusted')->after('qty_sold')->nullable();
            $table->string('qty_return')->after('qty_adjusted')->nullable();
            $table->string('qty_transfer')->after('qty_return')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
