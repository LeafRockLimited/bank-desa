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
        Schema::create('rekap_keuangans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade');
            $table->decimal('total_pinjaman', 15, 2);
            $table->decimal('total_angsuran', 15, 2);
            $table->decimal('total_bunga_dibayar', 15, 2);
            $table->decimal('total_simpanan', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekap_keuangans');
    }
};
