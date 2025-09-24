<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoreTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_tokens', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('store_id')->index();
            $table->string('token', 20); // Token sederhana seperti "54321"
            $table->timestamps();
            
            // Foreign key constraint
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            
            // Unique constraint untuk store_id (satu token per toko)
            $table->unique('store_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_tokens');
    }
}
