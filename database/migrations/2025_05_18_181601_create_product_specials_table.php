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
        Schema::create('product_specials', function (Blueprint $table) {
            $table->unsignedBigInteger('special_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();

            $table->primary(['special_id', 'product_id']);

            $table->foreign('special_id')->references('id')->on('specials')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_specials');
    }
};
