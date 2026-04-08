<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Relasi ke tabel anggota
    public function anggota()
    {
        return $this->hasOne(Anggota::class, 'user_id');
    }

    // Relasi ke tabel transaksi
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'user_id');
    }
}