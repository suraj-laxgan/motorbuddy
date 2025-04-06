<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_books', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('user_id'); 
            $table->unsignedMediumInteger('technician_id')->nullable(); 
            $table->tinyInteger('book_quantity')->default(1);
            $table->integer('amount');
            $table->string('coupon');
            $table->tinyInteger('discount_type')->comment('0: No Discount, 1: Flat Discount, 2: Percentage Discount');
            $table->integer('discount_amount')->default(0);
            $table->integer('tax_amount')->default(0);
            $table->integer('total_amount');
            $table->string('address');
            $table->string('payment_method');
            $table->tinyInteger('payment_receive')->comment('1: Yes, 2: No')->default(2);
            $table->string('transaction_id');
            $table->timestamp('scheduled_time')->nullable(); 
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
        Schema::dropIfExists('service_books');
    }
}
