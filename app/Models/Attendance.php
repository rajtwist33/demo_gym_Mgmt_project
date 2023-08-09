<?php

namespace App\Models;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable=(
    [
        'user_id',
        'shift_id',
        'date',
        'status',
        'remark'
    ]);
        public function getShift(){
            return $this->belongsTo(Shift::class,'shift_id');
        }
    
        public function getUser(){
            return $this->belongsTo(User::class,'user_id');
        }
    
    
}
