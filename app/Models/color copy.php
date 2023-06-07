<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Cviebrock\EloquentSluggable\Sluggable;

class color extends Model
{
    use HasFactory;
    protected $table='colors';
    
    protected $fillable = [
        'title',
        'code',
       
       
    ];
  
    // public function Subcategories() {
    //     return $this->hasMany(Subcategories::class, 'category_id_fk', 'id');
    // }
}
