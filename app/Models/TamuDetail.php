<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TamuDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'usia',
        'pendidikan',
        'alamat',
        'kota',
        'user_id',
    ];

}
