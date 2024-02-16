<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookBorrow extends Model
{
    use HasFactory;
    protected $table = 'book_borrows';
    public $timestamps = true;

    protected $fillable = [
        'id_siswa',
        'tanggal_pinjam',
        'tanggal_kembali'
    ];
}
