<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    protected $table = "maintenance";
    protected $fillable = [
        'equipment_id',
        'user_id',
        'maintained_date',
        'returned_date',
        'remarks',
        'issue',
        'action_taken',
        'recommendations',
        'technician',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    protected $casts = [
        'maintained_date' => 'datetime',
        'returned_date' => 'datetime',
    ];
    
}
