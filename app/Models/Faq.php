<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
protected $table ="faqs";
    protected  $fillable = [
        'page_id',
        'title',
        'description',  
    ];

    public function insurance() {
        return $this->belongsTo(Insurance::class, 'page_id','id');
    }
}
