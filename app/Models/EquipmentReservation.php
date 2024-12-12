<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentReservation extends Model
{
    protected $table = "equipment_reservations";
    protected $fillable = [
        'reservers_id_no',
        'equipment_id',
        'office_id',
        'reservation_date',
        'expected_return_date',
        'returned_date',
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
        return $this->belongsTo(Students::class, 'reservers_id_no', 'id');
    }
    
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'reservers_id_no', 'id');
    }
}
