<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondDayScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'randomNum', 'attendedTime'
    ];
}
