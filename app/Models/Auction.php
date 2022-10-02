<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'bids',
        'total_value',
        'description',
        'start_date',
        'is_finished',
        'end_date',
    ];
}
