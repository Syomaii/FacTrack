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
        'borrowers_name',
        'borrowers_id_no',
        'user_id',
        'borrowed_date',
        'expected_returned_date',
        'returned_date',
        'status',
    ];
}
