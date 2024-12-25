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
        Schema::create('jurnals', function (Blueprint $table) {
            $table->id();
            $table->string('no_bukti');
            $table->unsignedBigInteger('id_rekening');
            $table->double('debit',18,2)->default(0);
            $table->double('kredit',18,2)->default(0);
            $table->double('jumlah',18,2)->default(0);
            $table->string('keterangan')->nullable();
            $table->string('komponen_lak')->nullable();
            $table->foreign('id_rekening')->references('id')->on('kode_rekenings')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jurnals');
    }
};
