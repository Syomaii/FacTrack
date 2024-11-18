<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; 
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = "users";
    protected $fillable = [
        'designation_id',
        'office_id',
        'student_id',
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

    protected $casts = [
        'last_login_at' => 'datetime',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function student()
    {
        return $this->hasOne(Students::class);
    }

}
