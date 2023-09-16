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
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            
            $table->foreignId('order_id')
                ->constrained('orders')
                ->cascadeOnDelete();
            
            $table->foreignId('product_id')
                ->nullable()
                ->constrained('products')
                ->nullOnDelete();
            
            $table->unsignedFloat('discount')->default(0);

            $table->unsignedFloat('tax')->default(0); // الضريبة

            $table->unsignedFloat('total')->default(0);

            $table->string('product_name'); // في حال قام الأدمن بتغير اسم المنتج فانا ما بتاثر فيه وبضل محتفظ بالمنتج هذه العملية والي تحتها عبارة عن نسخ للاسم والسعر في حال تم تغيرهن لاحقا
            
            $table->unsignedFloat('price'); // هذه معناها اي تغير بصير على المنتج ما راح يتأثر بالسعر الجديد
                
            $table->unsignedSmallInteger('quantity')->default(1) ;

            $table->unique(['order_id' , 'product_id']); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
