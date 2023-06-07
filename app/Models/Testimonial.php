<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;
    protected $table='testimonials';

 
    protected $fillable = [
        'page_id',
        'sectiontitle',
        'title',
        'description'
    ];
    public function sluggable() :array {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function insurance() {
        return $this->belongsTo(Insurance::class, 'page_id','id');
    }
}
