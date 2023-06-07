<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Portfolio extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'status',
        'featured_image',
        'order_no',
        'description',
        'meta_title',
        'meta_description',
        'servicetype_id_fk'
    ];

    public function sluggable():array {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function service() {
        return $this->belongsTo(Service::class, 'service_id_fk');
    }
}
