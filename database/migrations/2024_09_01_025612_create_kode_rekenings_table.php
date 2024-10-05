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
        Schema::create('kode_rekenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_rekening_id')->constrained('jenis_rekenings')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nomor_rekening');
            $table->string('nama_rekening');
            $table->enum('tipe', ['pendapatan', 'pengeluaran','pembiayaan']);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->string('deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kode_rekenings');
    }
};
