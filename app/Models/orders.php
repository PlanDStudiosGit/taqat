<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
   
    use HasFactory;
    protected $table='orders';
    
    protected $fillable = [
        'id',
        'customer_id',
        'shipping_id',
        'billing_id',
        'total',
        'status',
        'created_at',
        'updated_at',

    ];
}
