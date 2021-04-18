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

    public function department(){
        return $this->hasOne(usersdepartemen::class,'id','departemen_id');
    }

}
