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
        Schema::create('book_borrows', function (Blueprint $table) {
            $table->bigIncrements('id_pinjam_buku');
            $table->unsignedBigInteger('id_siswa');
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_siswa')->references('id_siswa')->on('students');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_borrows');
    }
};
