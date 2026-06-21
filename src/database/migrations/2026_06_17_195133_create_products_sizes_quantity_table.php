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
        Schema::create('products_sizes_quantity', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->OnDelete('cascade');
            $table->foreignId('size_id')->constrained('clothes_sizes')->OnDelete('cascade');
            $table->integer('quantity')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_sizes_quantity');
    }
};
