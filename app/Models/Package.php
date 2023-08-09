<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'discount',
        'start_date',
        'end_date',
        'status',
        'slug'    
    ];
}
