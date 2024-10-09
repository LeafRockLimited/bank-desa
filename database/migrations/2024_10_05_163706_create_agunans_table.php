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
        Schema::create('agunans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pinjaman_id')->constrained('pinjamans')->onDelete('cascade');
            $table->string('jenis_agunan');
            $table->decimal('nilai_agunan', 15, 2);
            $table->text('deskripsi_agunan')->nullable();
            $table->date('tanggal_diserahkan');
            $table->string('status_agunan')->default('tercatat'); // Tercatat, Diserahkan, Dilepaskan
            $table->string('gambar_agunan')->nullable(); // Kolom untuk path gambar agunan
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agunans');
    }
};
