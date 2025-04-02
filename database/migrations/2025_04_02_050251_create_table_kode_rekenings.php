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
            $table->string('module', 100)->default('general'); // Modul terkait (Tabungan, Pinjaman, dll.)
            $table->string('nomor_rekening')->unique(); // Kode akun unik
            $table->string('nama_rekening'); // Nama akun
            $table->text('deskripsi')->nullable();
            $table->foreignId('parent_id')->nullable()->constrained('kode_rekenings')->onDelete('cascade'); // Hierarki COA
            $table->string('saldo_normal', 10)->nullable(); // Debit/Kredit normal
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
