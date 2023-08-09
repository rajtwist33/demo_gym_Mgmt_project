<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Backupadvancetable extends Model
{
    use HasFactory;
    protected $table = "backupadvancetables";
    protected $fillable = [
        'user_id',
        'payment_id',
        'backup_advance',
        'slug'
    ];
}
