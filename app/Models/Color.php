<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;


    protected $table = 'color';

    protected $fillable = [
        'color_name',
        'color_code',
        'rate_per_gram',
        'meter_value',
        'current_value',
        'status',
        'is_group'
    ];
}
