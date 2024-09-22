<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        DB::statement('TRUNCATE TABLE kode_rekenings');
        Schema::table('kode_rekenings', function (Blueprint $table) {
            $table->dropColumn('kode_rekening');
            $table->foreignId('jenis_rekening_id')->references('id')->on('jenis_rekenings');
            $table->string('nomor_rekening');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kode_rekenings', function (Blueprint $table) {
            $table->json('kode_rekening');
            $table->dropConstrainedForeignId('jenis_rekening_id');
            $table->dropColumn('nomor_rekening');
        });
    }
};
