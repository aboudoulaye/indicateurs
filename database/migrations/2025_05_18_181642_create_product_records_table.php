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
        Schema::create('product_records', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('record_id');
            $table->integer('stock_initial');
            $table->integer('qte_recu');
            $table->integer('qte_distribuée');
            $table->integer('perte_ajustement');
            $table->integer('sdu');
            $table->integer('cmm');
            $table->integer('nbr_jrs');
            $table->integer('qte_proposee');
            $table->integer('qte_cmde');
            $table->integer('qte_approuve');
            $table->string('explication');
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('record_id')->references('id')->on('records')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_records');
    }
};
