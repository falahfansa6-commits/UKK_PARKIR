<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class LogAktivitas extends Model
{
    protected $table = 'tb_log_aktivitas';
    protected $primaryKey = 'id_log';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'aktivitas',
        'waktu_aktivitas',
        
    ];

    public static function catat(string $aktivitas, $iduser = null): void
    {
        static::create([
            'id_user' => $idUser ?? auth()->id(),
            'aktivitas' => $aktivitas,
            'waktu_aktivitas' => now(),
        ]);
    }

    

    public function User()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
