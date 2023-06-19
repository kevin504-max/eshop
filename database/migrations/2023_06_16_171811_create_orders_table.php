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
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->string('username');
            $table->string('email');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('cpf_cnpj')->nullable();
            $table->string('phone')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->decimal('total_price', 15, 2);
            $table->string('message')->nullable();
            $table->string('tracking_number');
            $table->timestamps();
            $table->softDeletes();
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
