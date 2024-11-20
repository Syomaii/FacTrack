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
        'password',
        'course',
        'type',
        'department',
    ];

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public function borrows()
    {
        return $this->hasMany(Borrower::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
}
