<?php

namespace App\Models;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Advance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'shift_id',
        'initial_advance',
        'startdate',
        'enddate',
        'remaining_advance',
        'slug'
    ];

    public function getUser()
    {
     return $this->hasOne(User::class,'id','user_id');
    }
    public function getshift()
    {
     return $this->hasOne(Shift::class,'id','shift_id');
    }

    public function getUserdetail(){
        return $this->hasOne(Userdetail::class,'user_id','user_id');
    }
}
