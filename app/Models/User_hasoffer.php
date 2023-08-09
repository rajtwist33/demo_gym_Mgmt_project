<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_hasoffer extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'offer_id',
        'status',
        'slug',
    ];

    public function offer(){
        return $this->hasOne(Package::class, 'id', 'offer_id');
    }
}
