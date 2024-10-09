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
        Schema::create('buku_besars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kode_rekening')->references('id')->on('kode_rekenings')
            ->onDelete('cascade')->onUpdate('cascade');
            $table->string('keterangan')->nullable();
            $table->string('nomor_ref')->nullable();
            $table->string('komponen_laporan_arus_kas')->nullable();
            $table->string('buku_pembantu')->nullable();
            $table->integer('jumlah_unit')->nullable();
            $table->date('tanggal'); // Tanggal transaksi
            $table->decimal('debit', 15, 2)->default(0); // Kolom debit
            $table->decimal('kredit', 15, 2)->default(0); // Kolom kredit
            $table->decimal('saldo', 15, 2)->default(0); // Saldo setelah transaksi
            $table->timestamps(); // created_at dan updated_at
            $table->softDeletes(); // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buku_besars');
    }
};
