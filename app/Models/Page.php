<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Page extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'status',
        'featured_image',
        'description',
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
}
