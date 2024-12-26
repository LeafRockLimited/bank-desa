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
        Schema::create('neracas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_rekening');
            $table->integer('tahun');
            $table->integer('bulan');
            $table->double('neraca_debit',18,2)->default(0);
            $table->double('neraca_kredit',18,2)->default(0);
            $table->double('saldo_debit',18,2)->default(0);
            $table->double('saldo_kredit',18,2)->default(0);
            $table->double('jumlah',18,2)->default(0);
            $table->timestamps();
            $table->foreign('id_rekening')->references('id')->on('kode_rekenings')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('neracas');
    }
};
