<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;


class Category extends Model
{
    use HasFactory, Sluggable;
    protected $table='categories';
    
    protected $fillable = [
        'title',
        'slug',
        'status',
        'featured_image',
        'meta_title',
        'meta_description'
    ];
    public function sluggable():array {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function Subcategories() {
        return $this->hasMany(Subcategories::class, 'category_id_fk', 'id');
    }
    public function product() {
        return $this->hasMany(product::class, 'category_id',	'id');
    }
}
