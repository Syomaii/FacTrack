<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donated extends Model
{
    protected $table = "donated";
    protected $fillable = [
        'equipment_id',
        'user_id',
        'donated_date',
        'condition',
        'recipient',
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
        'donated_date' => 'datetime',
        'returned_date' => 'datetime',
    ];
}
