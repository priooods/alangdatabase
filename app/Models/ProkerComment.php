<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProkerComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'komentar',
    ];

    public function userName(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
