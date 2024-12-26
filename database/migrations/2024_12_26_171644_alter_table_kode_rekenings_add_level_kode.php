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
        Schema::table('kode_rekenings', function (Blueprint $table) {
            $table->string('level_one')->nullable();
            $table->string('uraian_level_one')->nullable();
            $table->string('level_two')->nullable();
            $table->string('uraian_level_two')->nullable();
            $table->string('level_three')->nullable();
            $table->string('uraian_level_three')->nullable();
            $table->string('level_four')->nullable();
            $table->string('uraian_level_four')->nullable();
            $table->string('level_five')->nullable();
            $table->string('uraian_level_five')->nullable();
            $table->string('level_six')->nullable();
            $table->string('uraian_level_six')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kode_rekenings', function (Blueprint $table) {
            $table->dropColumn([
                'level_one',
                'level_two',
                'level_three',
                'level_four',
                'level_five',
                'level_six',
            ]);
        });
    }
};
