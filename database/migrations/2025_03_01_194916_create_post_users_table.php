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
        Schema::create('post_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->string('full_name');
            $table->string('phone');
            $table->decimal('amount'); //ödenecek tutar
            $table->decimal('tax'); //ödenecek tutar
            $table->string('payment_type');
            $table->string('proxy'); //vekalet
            $table->string('proxy_phone'); //vekalet phone
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_users');
    }
};
