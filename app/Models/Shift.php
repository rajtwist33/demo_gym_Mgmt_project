<?php

namespace App\Models;

use App\Models\Attendance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Shift extends Model
{
    protected $fillable = [
        'shift_name',
        'slug',
        'starttime',
        'endtime'
    ];

    public function getAttendance()
    {
        return $this->hasMany(Attendance::class,'shift_id');
    }
}
