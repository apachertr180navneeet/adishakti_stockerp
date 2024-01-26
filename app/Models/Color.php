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
        'combination_color_a',
        'combination_gm_a',
        'combination_color_b',
        'combination_gm_b',
        'chemical_color_a',
        'chemical_gm_a',
        'chemical_color_b',
        'chemical_gm_b',
        'status'

    ];
}
