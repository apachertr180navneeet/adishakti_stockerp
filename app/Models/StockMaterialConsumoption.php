<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMaterialConsumoption extends Model
{
    use HasFactory;


    protected $table = 'stock_meterial_consumption';

    protected $fillable = [
        'stock_material_id',
        'counsumption_item_id',
        'rate',
        'qty',
        'total_amount'
    ];
}
