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
        Schema::create('laba_rugi_level3s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('level_two_id');
            $table->integer('level_three');
            $table->boolean('is_shown')->default(true);
            $table->integer('tahun');
            $table->integer('bulan');
            $table->decimal('total_this_month',18,2)->default(0);
            $table->decimal('total_till_this_month',18,2)->default(0);
            $table->timestamps();
            $table->foreign('level_two_id')->references('id')->on('laba_rugi_level2s')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laba_rugi_level3s');
    }
};
