<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    public $timestamps = false;

    protected $table = 'anggota';

    protected $fillable = [
        'user_id',
        'kelas_id',
        'no_telp',
        'nis',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}