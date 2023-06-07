<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class shipping extends Model
{
   
    use HasFactory;
    protected $table='shipping';
    
    protected $fillable = [
        'id',
        's_name',
        's_email',
        's_address',
        's_city',
        's_country',
        's_zip',
      

    ];
}
