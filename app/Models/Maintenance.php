<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Maintenance extends Model
{
    use Notifiable;
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

    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id'); // Adjust 'office_id' as necessary
    }

    protected $casts = [
        'maintained_date' => 'datetime',
        'returned_date' => 'datetime',
    ];
    
}
