<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('home_banner_line1', 100)->nullable();
            $table->string('home_banner_line2', 100)->nullable();
            $table->text('home_banner_image')->nullable();
            $table->text('home_banner_image_mobile')->nullable();
            $table->text('logo')->nullable();
            $table->text('favicon')->nullable();
            $table->text('banner_video')->nullable();
            $table->text('what_makes_us_different_line1')->nullable();
            $table->text('what_makes_us_different_line2')->nullable();
            $table->text('testimonial_line1')->nullable();
            $table->text('testimonial_line2')->nullable();
            $table->text('testimonial_video')->nullable();
            $table->binary('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->text('facebook_link')->nullable();
            $table->text('instagram_link')->nullable();
            $table->text('youtube_link')->nullable();
            $table->text('yelp_link')->nullable();
            $table->text('linkedin_link')->nullable();
            $table->text('twitter_link')->nullable();
            $table->text('google_link')->nullable();
            $table->string('homepage_meta_title')->nullable();
            $table->string('homepage_meta_description')->nullable();
            $table->string('blog_page_meta_title')->nullable();
            $table->string('blog_page_meta_description')->nullable();
            $table->string('contact_page_meta_title')->nullable();
            $table->string('contact_page_meta_description')->nullable();
            $table->string('gallery_page_meta_title')->nullable();
            $table->string('gallery_page_meta_description')->nullable();
            $table->text('header_scripts')->nullable();
            $table->text('body_start_scripts')->nullable();
            $table->text('body_end_scripts')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
