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
                ->nullOnDelete();
            $table->unsignedFloat('discount')->default(0);
            $table->unsignedFloat('tax')->default(0);
            $table->unsignedFloat('total')->default(0);
            $table->enum('status', ['pending', 'processing', 'shipped', 'received', 'cancelled', 'refunded']);
            $table->enum('payment_status', ['pending', 'paid', 'failed']);
            $table->string('payment_method')->nullable();
            $table->string('payment_transaction_id')->nullable();
            $table->json('payment_data')->nullable();
            $table->string('ip', 15);
            $table->string('user_agent');

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
