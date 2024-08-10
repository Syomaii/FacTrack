<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "users";
    protected $fillable = [
        'designation_id',
        'office_id',
        'firstname',
        'lastname',
        'email',
        'password',
        'mobile_no',
        'image',
        'status',
        'type',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */

    // /**
    //  * Get the attributes that should be cast.
    //  *
    //  * @return array<string, string>
    //  */
    // protected function casts(): array
    // {
    //     return [
    //         'email_verified_at' => 'datetime',
    //         'password' => 'hashed',
    //     ];
    // }

    // User.php
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

}
