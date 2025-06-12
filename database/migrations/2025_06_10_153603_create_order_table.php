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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('amount')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->text('stripe_id')->nullable();
            $table->timestamps();
        });

        schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->nullable()->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->nullable()->onDelete('cascade');
            $table->integer('quantity')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->integer('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
