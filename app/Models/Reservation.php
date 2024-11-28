<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = "reservation";
    protected $fillable = [
        'student_id',
        'equipment_id',
        'office_id',
        'reservation_date',
        'expected_return_date',
        'status',
        'purpose',
    ];

    public function offices()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id', 'id');
    }
}