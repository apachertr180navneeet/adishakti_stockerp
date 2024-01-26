<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMaterialManagemnt extends Model
{
    use HasFactory;


    protected $table = 'stock_material_managemnt';

    protected $fillable = [
        'stock_material_managemnt_date',
        'production_total',
        'consumption_total',
        'source_location',
        'destination_location',
        'status'
    ];
}
