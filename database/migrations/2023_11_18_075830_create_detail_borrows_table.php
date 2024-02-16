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
        Schema::create('detail_borrows', function (Blueprint $table) {
            $table->bigIncrements('id_detail_pinjam_buku');
            $table->integer('qty');
            $table->unsignedBigInteger('id_pinjam_buku');
            $table->unsignedBigInteger('id_buku');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('id_pinjam_buku')->references('id_pinjam_buku')->on('book_borrows');
            $table->foreign('id_buku')->references('id_buku')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_borrows');
    }
};
