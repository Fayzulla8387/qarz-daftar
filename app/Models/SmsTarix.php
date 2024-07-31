<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsTarix extends Model
{
    use HasFactory;
    protected $fillable = [
        'phone',
        'text',
        'status',
        'user_id',
        'sms_id'
    ];
}
