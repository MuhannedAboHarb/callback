<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->string('number')->unique();

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete(); // ما يتم حذف اليوز فقط يتم وضع نل

              
                
            $table->enum('status' , ['pending' ,'processing' ,'shipped' ,'received' ,'cancelled' ,'refunded']);

            $table->enum('payment_status' , ['pending' , 'paid' , 'falied']); //حاول يدفع إلكترونيا بس فشلت المحاولة

            $table->string('payment_method')->nullable();

            $table->string('payment_transaction_id')->nullable(); //رقم فاتورة تم انشائها في بيبال

            $table->json('payment_data')->nullable(); // بترجع تفاصيل عمليات الدفع الي صارت


            $table->string('ip' ,15);

            $table->string('user_agent'); //browser

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
