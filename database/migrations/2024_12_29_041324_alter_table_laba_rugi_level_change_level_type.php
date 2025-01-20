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
        Schema::table('laba_rugi_level1s', function (Blueprint $table) {
            $table->string('level_one')->change();
        });
        Schema::table('laba_rugi_level2s', function (Blueprint $table) {
            $table->string('level_two')->change();
        });
        Schema::table('laba_rugi_level3s', function (Blueprint $table) {
            $table->string('level_three')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laba_rugi_level1s', function (Blueprint $table) {
            $table->integer('level_one')->change();
        });
        Schema::table('laba_rugi_level2s', function (Blueprint $table) {
            $table->integer('level_two')->change();
        });
        Schema::table('laba_rugi_level3s', function (Blueprint $table) {
            $table->integer('level_three')->change();
        });
    }
};
