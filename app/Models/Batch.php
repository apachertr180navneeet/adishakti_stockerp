<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;


    protected $table = 'batch';

    protected $fillable = [
        'batch_name',
        'machine_number',
        'batch_code',
        'date_of_mgf',
        'status',
    ];
}
