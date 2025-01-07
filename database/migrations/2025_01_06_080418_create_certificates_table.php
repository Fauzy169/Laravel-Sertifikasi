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
    Schema::create('certificates', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Nama penerima sertifikat
        $table->string('course'); // Nama kursus atau pelatihan
        $table->string('duration')->default('Tidak Ditentukan'); // Durasi pelatihan dengan default
        $table->date('date'); // Tanggal pelatihan selesai
        $table->string('credential_number')->nullable(); // Nomor Credential
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
