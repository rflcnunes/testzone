<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'value',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class, 'offer_user', 'offer_id');
    }
}
