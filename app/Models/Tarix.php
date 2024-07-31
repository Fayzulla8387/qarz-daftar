<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarix extends Model
{
    use HasFactory;
    protected $fillable = [
        'qarzdor_id',
        'debt',
        'caption',
        'user_id',
    ];
    public function qarzdor()
    {
        return $this->belongsTo(Qarzdor::class,'qarzdor_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
