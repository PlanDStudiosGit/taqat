<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Cart extends Model
{
    use HasFactory, Sluggable;
    protected $table='carts';
    
    protected $fillable = [
        'title',
        'slug',
        'price',
        'qty',
        'color_id',
        'size_id',

    ];
}
