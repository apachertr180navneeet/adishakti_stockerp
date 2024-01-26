<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;


    protected $table = 'item';

    protected $fillable = [
        'item_name',
        'item_description',
        'unit_id',
        'vendor_id',
        'status',
    ];
}
