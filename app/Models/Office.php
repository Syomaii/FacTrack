<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;
protected $table = "offices";
    protected $fillable = [
        'name',
        'description',
        'type'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }
    public function getIconClass()
    {
        $type = strtolower($this->type); 
        
        if ($type === 'department') {
            return 'mingcute:home-6-fill'; 
        } elseif ($type === 'office') {
            return 'fluent:toolbox-20-filled'; 
        } else {
            return 'mingcute:tool-fill'; 
        }
    }
    
}
