<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Role extends Model
{
    protected $fillable = [
        'name',
        'slug'    
    ];
    //Primary Key
   public $primaryKey = 'id';

   //Timestamps
   public $timestamp = true;

   public function user()
   {
       return $this->hasOne(User::class,'role');
   }

}
