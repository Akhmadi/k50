<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('title');
	        $table->string('image')->nullable();
	        $table->string('slug')->nullable();
	        $table->text('excerpt')->nullable();
	        $table->text('body')->nullable();
	        $table->integer('user_id')->unsigned();

	        $table->foreign('user_id', 'foreign_posts_user_id')
	              ->references('id')
	              ->on('users')
	              ->onDelete('cascade');

	        $table->integer('post_type_id')->unsigned();

	        $table->foreign('post_type_id', 'foreign_posts_post_type_id')
	              ->references('id')
	              ->on('post_types');

	        $table->json('meta')->nullable();
	        $table->string('status');
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
	    Schema::table('posts', function(Blueprint $table){
		    $table->dropForeign('foreign_posts_user_id');
		    $table->dropForeign('foreign_posts_post_type_id');
	    });

        Schema::dropIfExists('posts');
    }
}
