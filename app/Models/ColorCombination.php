<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorCombination extends Model
{
    use HasFactory;


    protected $table = 'color_combination';

    protected $fillable = [
        'name',
        'gram',
        'color_id'

    ];
}
