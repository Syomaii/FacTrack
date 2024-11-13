<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;
    protected $table = "facilities";
    protected $fillable = [
        'name',
        'description',
        'type',
        'office_id'
    ];

    public function getIconClass()
    {
        $name = strtolower($this->type);
        if (strpos($name, 'laboratory') !== false) {
            return 'ri:computer-fill';
        } elseif (strpos($name, 'room') !== false) {
            return 'mingcute:home-6-fill';
        } elseif (strpos($name, 'office') !== false) {
            return 'mdi:door-open'; 
        } else {
            return 'mingcute:folder-fill';    
        }
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function equipment()
    {
        return $this->hasMany(Equipment::class);
    }
}
