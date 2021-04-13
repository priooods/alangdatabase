<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usersdetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'alamat',
        'motto',
        'pekerjaan',
        'pendidikan',
        'contact',
        'sosmed',
        'user_id',
        'departemen_id'
    ];

}
