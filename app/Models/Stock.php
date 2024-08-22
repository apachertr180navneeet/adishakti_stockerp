<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $fillable = [
        'stock_date',
        'vendor_id',
        'company_id',
        'status',
        'total_amount',
        'qty',
        'gadhiL'
    ];

    // Define relationships if any
    // For example, if Stock belongs to a Vendor
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
