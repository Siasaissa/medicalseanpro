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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('brand_name');
            $table->string('category');
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->decimal('discount', 5, 2)->nullable();
            $table->text('description')->nullable();
            $table->json('images')->nullable(); // store multiple images as JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrati  ons.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
