<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsHrmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_hrms', function (Blueprint $table) {
            $table->id(); 
            $table->string('min_check_int',30)->nullable();
            $table->string('max_check_int',30)->nullable();
            $table->string('min_check_out',30)->nullable();
            $table->enum('attendance_in_late',['yes','no'])->default('yes');
            $table->enum('attendance_to_salary',['yes','no'])->default('no');
            $table->enum('attendance_to_cutting',['yes','no'])->default('no');
            $table->string('salary_tax',30);
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
        Schema::dropIfExists('settings_hrms');
    }
}
