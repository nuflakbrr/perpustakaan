<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    public $timestamps = true;

    protected $fillable = ['judul_buku', 'author', 'deskripsi', 'cover'];
}
