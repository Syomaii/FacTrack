<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; 

class Students extends Model
{
    use HasApiTokens;

    protected $table = "students";

    protected $fillable = [
        'id',
        'firstname',
        'lastname',
        'gender',
        'email',
        'course',
        'department',
        'overdue_count' => 0,
    ];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public function borrows()
    {
        return $this->hasMany(Borrower::class, 'borrowers_id_no', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->hasMany(Reservation::class, 'student_id');
    }
}
