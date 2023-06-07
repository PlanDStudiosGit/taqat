<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'home_banner_line1',
        'home_banner_line2',
        'home_banner_image',
        'logo',
        'phone_number',
        'email',
        'facebook_link',
        'instagram_link',
        'youtube_link',
        'yelp_link',
        'linkedin_link',
        'twitter_link',
        'google_link',
        'homepage_meta_title',
        'homepage_meta_description',
        'blog_page_meta_title',
        'blog_page_meta_description',
        'contact_page_meta_title',
        'contact_page_meta_description'
    ];
}
