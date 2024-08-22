<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditNoteItem extends Model
{
    use HasFactory;


    protected $table = 'credit_note_item';

    protected $fillable = [
        'credit_note_id',
        'item_id',
        'credit_quantity',
        'credit_amount',
        'crdite_total_amount'
    ];
}
