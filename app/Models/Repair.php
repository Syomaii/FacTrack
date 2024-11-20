<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Repair extends Model


{
    use Notifiable;
    
    protected $table = "repairs";
    protected $fillable = [
        'equipment_id',
        'user_id',
        'repaired_date',
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
        'repaired_date' => 'datetime',
        'returned_date' => 'datetime',
    ];
}
