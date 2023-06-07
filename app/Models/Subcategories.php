<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Subcategories extends Model
{
    use HasFactory, Sluggable;
    protected $table='sub_categories';
    protected $fillable = [
        'title',
        'slug',
        'status',
        'featured_image',
        'description',
        'meta_title',
        'meta_description',
        'category_id_fk'
    ];
    public function sluggable() :array {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function category() {
        return $this->belongsTo(Category::class, 'category_id_fk','id');
    }
    public function product() {
        return $this->belongsTo(product::class, 'sub_category_id','id');
    }
}
