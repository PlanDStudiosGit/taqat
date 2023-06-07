<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class download extends Model
{
    use HasFactory, Sluggable;
    protected $table='insurances';

    protected $fillable = [
        'page_id',
        'title',
        'buttontext',
        'path',
    ];
    
    public function insurance() {
        return $this->belongsTo(Insurance::class, 'page_id','id');
    }
}
