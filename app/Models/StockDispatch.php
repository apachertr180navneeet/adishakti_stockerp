<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockDispatch extends Model
{
    use HasFactory;


    protected $table = 'stock_dispatch';

    protected $fillable = [
        'stock_date',
        'type',
        'from_id',
        'vendor_to_id',
        'branch_to_id',
        'status',
        'total_amount'
    ];
}
