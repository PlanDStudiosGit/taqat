<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Cviebrock\EloquentSluggable\Sluggable;

class size extends Model
{
    use HasFactory;
    protected $table='size';
    
    protected $fillable = [
        'title',
        
       
       
    ];
  
    // public function Subcategories() {
    //     return $this->hasMany(Subcategories::class, 'category_id_fk', 'id');
    // }
    public function product() {
        return $this->hasMany(product::class, 'size_id',	'id');
    }
}
