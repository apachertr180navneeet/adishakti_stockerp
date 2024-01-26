<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDispatch extends Model
{
    use HasFactory;


    protected $table = 'order_dispatch';

    protected $fillable = [
        'order_dispatch_date',
        'order_dispatch_number',
        'qty',
        'rate',
        'order_id',
        'amount',
        'status',
        'conditionmaster',
    ];
}
