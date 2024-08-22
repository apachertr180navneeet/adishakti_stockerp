<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDispatchItem extends Model
{
    use HasFactory;


    protected $table = 'stock_dispatch_item';

    protected $fillable = [
        'stock_id',
        'item_id',
        'stock_quantity',
        'stock_amount',
        'itemtotalamount'
    ];
}
