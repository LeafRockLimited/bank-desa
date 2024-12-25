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
        Schema::table('kode_rekenings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('jenis_rekening_id');
            $table->dropColumn('tipe');
            $table->string('saldo_normal')->nullable();
            $table->dropColumn('sub_tipe');
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kode_rekenings', function (Blueprint $table) {
            $table->foreignId('jenis_rekening_id')->constrained('jenis_rekenings')->onDelete('cascade')->onUpdate('cascade');
            $table->string('tipe')->index()->default('Pembiayaan');
            $table->string('sub_tipe')->index()->nullable();
            $table->string('status')->default('aktif');
            $table->dropColumn('saldo_normal');
        });
    }
};
