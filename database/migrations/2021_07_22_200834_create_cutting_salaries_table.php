<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuttingSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cutting_salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('designation_id')->index()->default(0);
            $table->unsignedBigInteger('store_id')->index();
            $table->string('name');
            $table->decimal('amount',22,3);
            $table->enum('priode',['day','month']);
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
        Schema::dropIfExists('cutting_salaries');
    }
}
