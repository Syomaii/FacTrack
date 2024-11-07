<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposed extends Model
{
    protected $table = "disposed";
    protected $fillable = [
        'equipment_id',
        'user_id',
        'disposed_date',
        'remarks',
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
        'disposed_date' => 'datetime',
        'returned_date' => 'datetime',
    ];
}

