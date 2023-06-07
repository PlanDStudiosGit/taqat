<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Insurance extends Model
{
    use HasFactory, Sluggable;
    protected $table='insurances';

    protected $fillable = [
        'id',
        'page_id',
        'name',
        'slug',
        'section1_title1',
        'section1_title2',
        'section1_image',
        'section1_description',
        'section2_title',
        'section2_description',
        'section2_buttontext',
        'section3_title',
        'section3_description',
        'section3_image',
        'section3_buttontext',
        'section4_main_title',
        'section4_1_image',
        'section4_1_title',
        'section4_1_decription',
        'section4_1_buttontext',
        'section4_2_image',
        'section4_2_title',
        'section4_2_decription',
        'section4_2_buttontext',
        'section4_3_image',
        'section4_3_title',
        'section4_3_decription',
        'section4_3_buttontext',
        'section4_4_image',
        'section4_4_title',
        'section4_4_decription',
        'section4_4_buttontext',

    ];
    
    public function sluggable():array {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
    public function downloads() {
        return $this->hasMany(download::class, 'page_id', 'id');
    }
    public function faqs() {
        return $this->hasMany(Faq::class, 'page_id','id');
    }
    public function testimonials() {
        return $this->hasMany(Testimonial::class, 'page_id','id');
    }
}
