<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('ref_no')->nullable();
            $table->unsignedBigInteger('category_id')->index();
            $table->unsignedBigInteger('store_id')->index();
            $table->string('name');
            $table->enum('refund', ['no', 'yes']);
            $table->longText('detail')->nullable();
            $table->string('document')->nullable();
            $table->decimal('amount',22,3);
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
        Schema::dropIfExists('expenses');
    }
}
