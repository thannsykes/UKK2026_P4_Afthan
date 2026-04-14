<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rak extends Model
{
    public $timestamps = false;

    protected $table = 'rak';

    protected $fillable = [
        'nama_rak',
        'lokasi',
    ];

    public function buku()
    {
        return $this->hasMany(Buku::class, 'rak_id');
    }
}