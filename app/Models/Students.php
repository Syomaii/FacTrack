<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $fillable = [
        'id_no',
        'firstname',
        'lastname',
        'gender',
        'email',
        'course',
        'department',
    ];
}
