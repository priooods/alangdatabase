<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'password',
        'avatar',
        'log',
        'fullname',
        'access_id',
        'gender',
        'password_verif',
    ];

    public function access(){
        return $this->belongsTo(usersacces::class, 'access_id', 'id');
    }
    public function detail(){
        return $this->belongsTo(usersdetail::class, 'id', 'user_id');
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
