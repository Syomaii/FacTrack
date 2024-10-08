<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Equipment extends Model
{
    use HasFactory;
    protected $table = "equipments";
    protected $fillable = [
        'brand',
        'name',
        'serial_no',
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

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($equipment) {
            if ($equipment->isDirty('status')) {
                // Check if the user is authenticated
                $userId = Auth::id(); 

                Timeline::create([
                    'equipment_id' => $equipment->id,
                    'status' => $equipment->status,
                    'user_id' => $userId, // Make sure this isn't null
                    'remarks' => 'Status updated to ' . $equipment->status,
                ]);
            }
        });
    }

    public function timeline()
    {
        return $this->hasMany(Timeline::class);
    }
}
