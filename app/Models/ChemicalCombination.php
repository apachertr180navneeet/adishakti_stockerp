<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChemicalCombination extends Model
{
    use HasFactory;


    protected $table = 'chemical_combination';

    protected $fillable = [
        'chemical_id',
        'chemical_item_id',
        'chemcical_qty',
        'chemical_calculation'
    ];
}
