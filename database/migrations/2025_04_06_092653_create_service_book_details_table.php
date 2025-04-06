<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBookDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_book_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('book_id'); 
            $table->unsignedMediumInteger('user_id'); 
            $table->unsignedMediumInteger('technician_id')->nullable(); 
            $table->unsignedMediumInteger('service_id'); 
            $table->integer('quantity');
            $table->integer('price');
            $table->tinyInteger('status')->comment('0: Preparing,  1: In-Progress, 2: Canceled, 3: Completed')->default(0);   
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('service_book_details');
    }
}
