<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timeline extends Model
{
    use HasFactory;

    protected $table = "timeline";

    protected $fillable = [
        'equipment_id',
        'user_id',
        'status',
        'remarks',
    ];

    public function equipment() {
        return $this->belongsTo(Equipment::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    // In Timeline.php model
public function borrow()
{
    return $this->belongsTo(Borrower::class, 'borrowers_id_no');
}

public function maintenance()
{
    return $this->belongsTo(Maintenance::class, 'maintenance_id');
}

}
