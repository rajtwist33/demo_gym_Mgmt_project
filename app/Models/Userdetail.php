<?php

namespace App\Models;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Model;


class Userdetail extends Model
{
    protected $table="userdetails";

    protected $fillable = [
        'user_id',
        'role_id',
        'phone',
        'address',
        'blood_type',
        'age',
        'gender',
        'dob',
        'shift_id',
        'reffered_by',
        'weight',
        'height',
        'parent_name',
       'gaurdian_name',
       'gaurdian_number',
       'card_no',
        'insurence',
        'fee',
        'payment',
        'discount',
        'admission',
        'break_notify',
        'physical_description',
        'paid_admission',
        'image',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function getUserOne()
    {
        return $this->hasOne(User::class,'id','user_id');
    }

    public function shifts()
    {
        return $this->belongsTo(Shift::class,'shift_id');
    }

    public function getShiftOne()
    {
        return $this->hasOne(Shift::class,'id','shift_id');
    }

}
