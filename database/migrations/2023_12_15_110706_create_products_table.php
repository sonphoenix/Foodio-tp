<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
     public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('user_id');
            $table->integer('storage');
            $table->decimal('price', 10, 2);
            $table->integer('min_pieces');
            $table->json('product_images');
            $table->text('description');
            $table->string('category');
            $table->string('sub_category');
            $table->decimal('rating', 3, 2)->nullable();
            $table->timestamps();

            // Foreign key relationship with the users table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
