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
            $table->unsignedBigInteger('id_jurnal');
            $table->unsignedBigInteger('id_rekening');
            $table->double('debit',18,2)->default(0);
            $table->double('kredit',18,2)->default(0);
            $table->double('saldo',18,2)->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_jurnal')->references('id')->on('jurnals')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_rekening')->references('id')->on('kode_rekenings')->onDelete('cascade')->onUpdate('cascade');
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
