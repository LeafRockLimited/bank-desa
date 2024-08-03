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
        Schema::create('pinjamans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade');
            $table->enum('jenis_pinjaman', ['mingguan', 'bulanan', 'musiman', 'tahunan']);
            $table->decimal('jumlah_pinjaman', 15, 2);
            $table->decimal('bunga', 5, 2);
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_disetujui')->nullable();
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status_pinjaman', ['pending', 'approved', 'rejected', 'paid']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pinjamans');
    }
};
