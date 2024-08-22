<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockItem extends Model
{
    use HasFactory;

    protected $table = 'stock_item';

    protected $fillable = [
        'stock_id',
        'item_id',
        'branch_id',
        'stock_quantity',
        'stock_amount',
        'item_total_amount',
        'unit',
        'gadhiL'
    ];
}
