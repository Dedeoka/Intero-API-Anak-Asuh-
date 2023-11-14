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
        Schema::create('prestasi_anak_asuhs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak_asuhs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('judul');
            $table->date('tanggal_lomba');
            $table->string('status');
            $table->string('bukti_prestasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi_anak_asuhs');
    }
};
