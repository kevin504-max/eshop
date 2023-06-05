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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->decimal('price', 15, 2);
            $table->decimal('discountPercentage', 15, 2)->nullable();
            $table->decimal('rating', 15, 2)->nullable();
            $table->integer('stock');
            $table->string('brand');
            $table->string('category');
            $table->string('thumbnail');
            $table->json('images');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
