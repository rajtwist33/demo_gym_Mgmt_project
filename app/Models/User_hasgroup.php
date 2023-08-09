<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_hasgroup extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'user_group',
        'slug',
    ];
    
    public function user_hasgroup(){
        return $this->hasOne(User::class, 'id', 'user_group');
    }
    public function user_contact(){
        return $this->hasOne(Userdetail::class, 'user_id', 'user_group');
    }

}
