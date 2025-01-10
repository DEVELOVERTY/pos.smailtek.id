<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTransactionCodeToLogFingers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('log_fingers', function (Blueprint $table) {
            $table->bigInteger('transaction_code')->nullable()->after('finger');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('log_fingers', function (Blueprint $table) {
            $table->dropColumn('transaction_code');
        });
    }
}
