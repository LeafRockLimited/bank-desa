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
        Schema::create('laba_rugi_level1s', function (Blueprint $table) {
            $table->id();
            $table->integer('level_one');
            $table->boolean('is_shown')->default(true);
            $table->integer('tahun');
            $table->integer('bulan');
            $table->double('total_this_month',18,2)->default(0);
            $table->double('total_till_this_month',18,2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laba_rugi_level1s');
    }
};
