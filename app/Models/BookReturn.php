<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookReturn extends Model
{
    use HasFactory;
    protected $table = 'book_returns';
    public $timestamps = true;

    protected $fillable = [
        'id_pinjam_buku',
        'tanggal_kembali',
        'denda'
    ];
}
