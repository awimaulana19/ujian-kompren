<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = ['soal'];

    public function jawaban()
    {
        return $this->hasMany(Jawaban::class);
    }

    public function hasil(){
        return $this->hasMany(Hasil::class);
    }
}
