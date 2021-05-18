<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proker extends Model
{
    use HasFactory;

    protected $casts = [
        'judul',
        'desc',
        'ketua',
        'department_id',
        'gol_point' => 'array',
        'tgl_mulai',
        'tgl_selesai',
        'lokasi'
    ];
    public function department(){
        return $this->belongsTo(usersdepartemen::class, 'department_id', 'id');
    }
    public function komentar(){
        return $this->hasMany(ProkerComment::class, 'proker_id', 'id');
    }
    public function userName(){
        return $this->belongsToMany(User::class);
    }
}
