<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = "reservation";
    protected $fillable = [
        'user_id',
        'equipment_id',
        'reservation_date',
        'expected_return_date',
        'status',
        'purpose',
    ];
}
