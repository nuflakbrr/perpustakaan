<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailBorrow extends Model
{
    use HasFactory;
    protected $table = 'detail_borrows';
    public $timestamps = true;

    protected $fillable = [
        'qty',
        'id_pinjam_buku',
        'id_buku'
    ];
}
