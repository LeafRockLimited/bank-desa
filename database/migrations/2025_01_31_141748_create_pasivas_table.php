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
        Schema::create('pasivas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pasiva')->unique();
            $table->enum('jenis_pasiva', [
                'tabungan', 'antar_bank_pasiva', 'pinjaman_bkd_lain',
                'pinjaman_lainnya', 'modal', 'rupa_rupa_pasiva',
                'laba_rugi_tahun_berjalan'
            ]);
            $table->decimal('nilai', 20, 2);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasivas');
    }
};
