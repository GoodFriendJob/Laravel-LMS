<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogModule extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blogs', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('content');
            $table->string('image')->nullable();
            $table->integer('views')->default(0);
            $table->text('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->longText('meta_keywords')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('blog_comments', function(Blueprint $table)
        {
            $table->increments('id');
            $table->unsignedInteger('blog_id');
            $table->unsignedInteger('user_id');
            $table->string('name');
            $table->string('email');
            $table->text('comment');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('tags', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('taggables', function(Blueprint $table)
        {
            $table->integer('tag_id');
            $table->integer('taggable_id');
            $table->string('taggable_type');
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //take backup before dropping table
        Schema::drop('blog_comments');

        Schema::drop('blogs');

        Schema::drop('tags');

        Schema::drop('taggables');
    }

}
