<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
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
}
