<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expense_id',
        'lat_from',
        'long_from',
        'lat_to',
        'long_to',
        'leters',
        'fuel_price_per_leter',
        'fuel_price_total',
        'prev_reading',
        'current_reading',
        'purpose',
        'distance',
        'journey'
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
