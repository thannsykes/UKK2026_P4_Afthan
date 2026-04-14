<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengarang extends Model
{
    public $timestamps = false;
    protected $table = 'pengarang';
    protected $fillable = ['nama_pengarang'];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'pengarang_id');
    }
}