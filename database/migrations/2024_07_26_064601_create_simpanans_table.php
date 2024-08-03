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
        Schema::create('simpanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained('nasabahs')->onDelete('cascade');
            $table->enum('jenis_simpanan', ['harian', 'mingguan', 'bulanan', 'tahunan']);
            $table->decimal('jumlah_simpanan', 15, 2);
            $table->decimal('bunga', 5, 2);
            $table->date('tanggal_setor');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simpanans');
    }
};
