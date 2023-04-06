<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;
    protected $table = 'peminjaman';
    protected $primarykey = 'id_peminjaman';
    public $timestamps = false;
    public $fillable = [
        'id', 'id_jurusan', 'id_buku', 'tgl_peminjaman', 'tgl_kembali', 'status', 'tenggat'
    ];
}
