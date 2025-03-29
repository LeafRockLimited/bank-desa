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

        Schema::create('simpanan_jenis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis_simpanan');
            $table->decimal('minimal_setoran', 15, 2)->default(0);
            $table->decimal('bunga_simpanan', 5, 2)->default(0);
            $table->boolean('bisa_dicairkan')->default(false);
            $table->timestamps();
        });
        
        Schema::create('simpanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade');
            $table->bigInteger('rekening_simpanan')->unique();
            $table->foreignId('jenis_simpanan_id')->constrained('simpanan_jenis')->onDelete('cascade');
            $table->date('tanggal_buka');
            $table->decimal('saldo_awal', 15, 2);
            $table->decimal('saldo_terkini', 15, 2);
            $table->enum('status_simpanan', ['Aktif', 'Tutup'])->default('Aktif');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('simpanan_transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('simpanan_id')->constrained('simpanans')->onDelete('cascade');
            $table->enum('jenis_transaksi', ['setoran', 'penarikan']);
            $table->decimal('nominal', 15, 2);
            $table->date('tanggal_transaksi');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });

        // Tabel Bunga Simpanan
        Schema::create('simpanan_bungas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('simpanan_id')->constrained('simpanans')->onDelete('cascade');
            $table->date('tanggal_perhitungan');
            $table->decimal('persentase_bunga', 5, 2);
            $table->decimal('nominal_bunga', 15, 2);
            $table->timestamps();
        });

        // Tabel Laporan Keuangan
        Schema::create('simpanan_laporans', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_laporan');
            $table->decimal('total_simpanan', 15, 2);
            $table->decimal('total_setoran', 15, 2);
            $table->decimal('total_penarikan', 15, 2);
            $table->decimal('total_bunga', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanan_laporans');
        Schema::dropIfExists('simpanan_bungas');
        Schema::dropIfExists('simpanan_transaksis');
        Schema::dropIfExists('simpanans');
        Schema::dropIfExists('simpanan_jenis');
    }
};
