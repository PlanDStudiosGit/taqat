<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order_detail extends Model
{
    use HasFactory; 
    protected $table='order_detail';
    
    protected $fillable = [
        'id',
        'order_id',
        'product_id',
        'product_name',
        'product_price',
        'product_sale_qty',
        'created_at',
        'updated_at',

    ];
    public function sluggable():array {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
}
}