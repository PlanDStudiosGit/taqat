<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class product extends Model
{
    use HasFactory, Sluggable;
    protected $table='products';
    protected $fillable = [
        'id',
        'title',
        'slug',  
        'category_id',
        'sub_category_id',
        'brand_id',
        'color_id',
        'size_id',
        'featured_image', 
        'price',
        'qty', 
    
    ];
    public function sluggable():array{
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    // public $timestamps=false;

    public function category() {
        return $this->belongsTo(Category::class,'category_id','id');
    }
    public function subcategory() {
        return $this->belongsTo(Subcategories::class,'sub_category_id','id');
    }
    public function brand() {
        return $this->belongsTo(brand::class,'brand_id','id');
    }
    public function color() {
        return $this->belongsTo(color::class,'color_id','id');
    }
    public function size() {
        return $this->belongsTo(Size::class,'size_id','id');
    }
}

