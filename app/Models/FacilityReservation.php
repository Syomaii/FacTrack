<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacilityReservation extends Model
{
    protected $table = "facility_reservations";
    protected $fillable = [
        'reservers_id_no',
        'facility_id',
        'office_id',
        'time_id',
        'time_out',
        'status',
        'purpose',
        'expected_audience_no',
        'stage_performers',
        'venue'
    ];

    public function offices()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }

    public function equipment()
    {
        return $this->belongsTo(Facility::class, 'facility_id', 'id');
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
