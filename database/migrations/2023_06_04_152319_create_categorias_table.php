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
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('slug');
            $table->longText('descricao');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('popular')->default(0);
            $table->string('imagem');
            $table->string('meta_titulo');
            $table->string('meta_descricao');
            $table->string('meta_keywords');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
