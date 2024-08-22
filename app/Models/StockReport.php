<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockReport extends Model
{
    use HasFactory;


    protected $table = 'stock_report';

    protected $fillable = [
        'item_id',
        'quantity',
        'status',
        'branch_id',
        'unit'
    ];
}
