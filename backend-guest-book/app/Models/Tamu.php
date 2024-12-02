<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tamu extends Model
{
    protected $fillable = [
        'nama',
        'tanggal_lahir',
        'ktp',
        'email'
    ];
}
