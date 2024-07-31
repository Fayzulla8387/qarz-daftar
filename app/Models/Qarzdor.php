<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qarzdor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'caption',
        'debt',
        'return_date',
        'limit',
        'type',
        'user_id',
    ];
}
