<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePortfoliosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug')->unique('blog_slug');
            $table->integer('order_no')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 = inactive, 1 = active');
            $table->text('featured_image')->nullable();
            $table->longText('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->unsignedInteger('service_id_fk')->nullable()->index('Service for portfolio');
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
        Schema::dropIfExists('portfolios');
    }
}
