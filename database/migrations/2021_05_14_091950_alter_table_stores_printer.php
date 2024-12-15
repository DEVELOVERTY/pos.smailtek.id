<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableStoresPrinter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->unsignedBigInteger('printer_id')->index()->after('currency_id');
            $table->integer('reference_format')->default(1)->after('currency_position');
            $table->string('gst')->nullable()->after('tax');
            $table->string('vat')->nullable()->after('gst');
            $table->foreign('printer_id')->references('id')->on('printers');
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
