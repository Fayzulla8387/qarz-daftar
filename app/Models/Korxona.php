<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Korxona extends Model
{
    use HasFactory;

    protected $fillable=
        [
            'name'
        ];
    public function qarzdorlar()
    {
        return $this->hasMany(Qarzdor::class, 'korxona_id');
    }
    public function totalDebt()
    {
        return $this->qarzdorlar()->sum('debt');
    }
}
