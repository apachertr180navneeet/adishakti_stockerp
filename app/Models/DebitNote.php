<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitNote extends Model
{
    use HasFactory;


    protected $table = 'debit_note';

    protected $fillable = [
        'debit_note',
        'debit_date',
        'type',
        'user_id',
        'branch_id',
        'grand_total',
        'add_amount',
        'final_amunt',
        'status',
    ];
}
