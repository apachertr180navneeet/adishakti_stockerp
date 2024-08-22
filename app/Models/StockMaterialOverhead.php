<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMaterialOverhead extends Model
{
    use HasFactory;


    protected $table = 'stock_meterial_overhead';

    protected $fillable = [
        'stock_material_id',
        'overhead_item_id',
        'amount'
    ];
}
