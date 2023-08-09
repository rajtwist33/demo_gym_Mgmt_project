<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnualPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_name',
        'set_amount',
        'no_month',
        'total_amount',
        'monthly_amount',
        'discount',
        'slug',
        
    ];
}
