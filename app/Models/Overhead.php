<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Overhead extends Model
{
    use HasFactory;


    protected $table = 'overhead';

    protected $fillable = [
        'name',
        'status',
    ];
}
