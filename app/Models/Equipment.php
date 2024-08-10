<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    protected $table = "equipments";
    protected $fillable = [
        'name',
        'facility_id',
        'description',
        'acquired_date',
        'code',
        'image',
        'status',
        'owned_by',
        'user_id'
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }
}
