<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable implements FilamentUser , HasName
{
   protected $table = 'tb_user';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'nama_lengkap', 'username', 'password', 'role', 'status_aktif'
    ];

    public $casts = [
        'password' => 'hashed',
        'status_aktif' => 'boolean',
    ];

    public function getFilamentName(): string
    {
        return $this->nama_lengkap ?: $this->username ?: 'User';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return (bool) $this->status_aktif;
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetugas(): bool
    {
        return $this->role === 'petugas';
    }

    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }
}



