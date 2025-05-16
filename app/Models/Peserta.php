<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peserta extends Model
{
    protected $table = "peserta";

    protected $fillable = ['kelompok_id', 'name'];

    public function kelompok()
    {
        return $this->belongsTo(Kelompok::class);
    }
}
