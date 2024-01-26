<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
    use HasFactory;


    protected $table = 'credit_note';

    protected $fillable = [
        'credit_note',
        'credit_date',
        'type',
        'user_id',
        'branch_id',
        'grand_total',
        'add_amount',
        'final_amunt',
        'status',
    ];
}
