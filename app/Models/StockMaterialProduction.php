<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMaterialProduction extends Model
{
    use HasFactory;


    protected $table = 'stock_meterial_production';

    protected $fillable = [
        'stock_material_id',
        'production_item_id',
        'rate',
        'qty',
        'total_amount'
    ];
}
