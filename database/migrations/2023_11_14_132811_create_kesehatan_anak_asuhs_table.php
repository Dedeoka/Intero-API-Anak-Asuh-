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
        Schema::create('kesehatan_anak_asuhs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak_asuhs')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('penyakit_id')->constrained('penyakits')->onDelete('cascade')->onUpdate('cascade');
            $table->string('status');
            $table->date('tanggal_sakit');
            $table->string('obat_penyakit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kesehatan_anak_asuhs');
    }
};
