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
    protected $table = "students";

    protected $primaryKey = 'id_no';

    public $incrementing = false;

    protected $keyType = 'string';

    
}
