<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    protected $table = "kelompok";

    protected $fillable = ['name'];

    public function peserta()
    {
        return $this->hasMany(Peserta::class);
    }
}
