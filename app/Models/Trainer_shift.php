<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Shift;

class Trainer_shift extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'role_id',
        'shift_id',
    ];

    public function shifts()
    {
        return $this->belongsTo(Shift::class,'shift_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
