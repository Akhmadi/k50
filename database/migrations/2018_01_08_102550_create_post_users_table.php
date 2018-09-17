<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_users', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('user_id')->unsigned()->nullable();

	        $table->foreign('user_id', 'foreign_posts_users_user_id')
	              ->references('id')
	              ->on('users')
	              ->onDelete('cascade');

	        $table->integer('post_id')->unsigned()->nullable();

	        $table->foreign('post_id', 'foreign_posts_users_post_id')
	              ->references('id')
	              ->on('posts')
	              ->onDelete('cascade');

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
	    Schema::table('posts_users', function (Blueprint $table) {
	    	$table->dropForeign('foreign_posts_users_user_id');
		    $table->dropForeign('foreign_posts_users_post_id');

	    });

        Schema::dropIfExists('posts_users');
    }
}
