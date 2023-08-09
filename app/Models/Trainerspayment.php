<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Shift;

class Trainerspayment extends Model
{
    protected $table = "trainerpayments";
    protected $fillable = [
        'user_id',
        'no_shift',
        'present',
        'amount',
        'month',
        'rate',
        'advance',
        'net_amount',
        'description',
        'previous_amount',
        'slug',
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function shifts()
    {
        return $this->belongsTo(Shift::class,'shift_id');
    }

}
