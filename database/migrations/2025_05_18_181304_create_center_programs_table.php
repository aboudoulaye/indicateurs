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
        Schema::create('center_programs', function (Blueprint $table) {
            $table->unsignedBigInteger('center_id');
            $table->unsignedBigInteger('program_id');
            $table->timestamps();

            $table->primary(['center_id','program_id']);

            $table->foreign('center_id')->references('id')->on('centers') ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('program_id')->references('id')->on('programs') ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('center_programs');
    }
};
