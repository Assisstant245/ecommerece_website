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
        Schema::create('admin_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable(); // Optional if cart is linked to user
            $table->unsignedBigInteger('user_id')->nullable(); // Optional if cart is linked to user

            $table->string('cart_product_name');
            $table->string('cart_product_sku');
            $table->string('cart_product_image');
            $table->decimal('cart_product_sale_price', 10, 2);
            $table->integer('cart_quantity')->default(1);  
            $table->decimal('total_price', 10, 2);

 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_carts');
    }
};
