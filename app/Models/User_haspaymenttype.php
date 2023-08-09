<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_haspaymenttype extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'paymenttype_id',
        'start_date',
        'end_date',
        'is_active',
        'slug',
    ];

    public function anual_payment(){
        return $this->hasOne(AnualPayment::class, 'id', 'paymenttype_id');
    }
}
