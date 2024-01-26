<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DebitNoteItem extends Model
{
    use HasFactory;


    protected $table = 'debit_note_item';

    protected $fillable = [
        'debit_note_id',
        'item_id',
        'debit_quantity',
        'debit_amount',
        'debit_total_amount'
    ];
}
