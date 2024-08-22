<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model
{
    use HasFactory;


    protected $table = 'item_stock';

    protected $fillable = [
        'item_id',
        'branch_id',
        'qty',
    ];
}
