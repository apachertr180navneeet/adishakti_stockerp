<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockChallan extends Model
{
    use HasFactory;


    protected $table = 'stock_challan';

    protected $fillable = [
        'challan_number',
        'order_date',
        'customer_id',
        'item_id',
        'branch_id',
        'quantity',
        'rate',
        'status',
        'conditionmaster',
        'actualconditionmaster',
    ];
}
