<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $table = "borrows";
    protected $fillable = [
        'equipment_id',
        'borrowers_id_no',
        'borrowers_name',
        'department',
        'purpose',
        'user_id',
        'borrowed_date',
        'expected_returned_date',
        'returned_date',
        'remarks',
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
