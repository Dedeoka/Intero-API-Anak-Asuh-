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
        Schema::create('pendidikan_anak_asuhs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anak_id')->constrained('anak_asuhs')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nama_jenjang');
            $table->string('nama_sekolah');
            $table->date('tanggal_lulus');
            $table->string('bukti_lulus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pendidikan_anak_asuhs');
    }
};
