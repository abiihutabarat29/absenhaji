<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KonfirmasiTugas extends Model
{
    protected $table = "konfirmasi_tugas";

    protected $fillable = ['tugas_id', 'user_id', 'status'];
}
