<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = "absensi";

    protected $fillable = ['tugas_id', 'peserta_id', 'user_id', 'status'];

    public function tugas()
    {
        return $this->belongsTo(Tugas::class);
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
