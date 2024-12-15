<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('employee_id')->index();
            $table->unsignedBigInteger('store_id')->index();
            $table->unsignedBigInteger('designation_id')->index();
            $table->decimal('cutting',22,4);
            $table->string('tax',10)->nullable();
            $table->decimal('allowance',22,4);
            $table->decimal("salary",22,4);
            $table->decimal('bonus',22,4)->nullable();
            $table->string('date');
            $table->string('attendance_this_month',10);
            $table->enum('method_payment',['Bank Transfer','Cash','Credit Card'])->nullable();
            $table->string('total_work');
            $table->decimal('total',22,4);
            $table->enum('status',['paid','due'])->default('due');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('salaries');
    }
}
