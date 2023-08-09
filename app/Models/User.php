<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\User_hasoffer;
use App\Models\Advance;
use App\Models\Userdetail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'status',
        'mode',
        'collapse',
        'dumy_join_date',
        'join_date',
        'slug',
        'pass_name',
        
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

     //Primary Key
     public $primaryKey = 'id';

     //Timestamps
     public $timestamp = true;
  
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected function role(): Attribute
    // {
    //     return new Attribute(
    //         get: fn ($value) =>  ["superadmin", "admin","developer","trainer","gymer"][$value],
    //     );
    // }

    public function roles()
    {
        return $this->hasOne(Role::class,'id','role');
    }
    public function user_hasoffer()
    {
        return $this->belongsTo(User_hasoffer::class,'id','user_id')->Where('status',1);
    }

    public function getUserDetail()
    {
        return $this->hasOne(Userdetail::class,'user_id');
    }

    public function getUserDetailMany()
    {
        return $this->hasMany(Userdetail::class,'user_id');
    }
   
    public function getAdvance()
    {
        return $this->hasMany(Advance::class,'user_id');
    }
    public function getAdvanceone()
    {
        return $this->hasOne(Advance::class,'user_id');
    }

    public function getUserPaymentMonth()
    {
        return $this->hasOne(Payment::class,'user_id')->orderBy('id', 'DESC');
    }

   


}
