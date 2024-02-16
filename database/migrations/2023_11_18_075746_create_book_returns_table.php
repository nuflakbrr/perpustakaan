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
        Schema::create('book_returns', function (Blueprint $table) {
            $table->bigIncrements('id_buku_kembali');
            $table->unsignedBigInteger('id_pinjam_buku');
            $table->date('tanggal_kembali');
            $table->integer('denda');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pinjam_buku')->references('id_pinjam_buku')->on('book_borrows');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_returns');
    }
};
