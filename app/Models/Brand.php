<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
{
    use HasFactory, Sluggable;
    protected $table='brands';
    protected $fillable = [
        'name',
        'slug',  
        'featured_image',  
    
    ];
    public function sluggable():array{
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    
    public function product() {
        return $this->hasMany(product::class, 'brand_id',	'id');
    }
}
