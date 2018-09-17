<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsPeoplePivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts_people', function (Blueprint $table) {
	        $table->integer('post_id')->unsigned();
	        $table->foreign('post_id', 'foreign_posts_people_post_id')
	              ->references('id')
	              ->on('posts')
	              ->onDelete('cascade');

	        $table->integer('person_id')->unsigned();

	        $table->foreign('person_id', 'foreign_posts_people_person_id')
	              ->references('id')
	              ->on('people')
	              ->onDelete('cascade');

	        $table->json('meta')->nullable();
	        $table->string('type', 20);
	        $table->index('type', 'idx_posts_people_type');

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
	    Schema::table('posts_people', function (Blueprint $table) {
		    $table->dropForeign(['foreign_posts_people_post_id', 'foreign_posts_people_person_id']);
		    $table->dropIndex('idx_posts_people_type');
	    });

        Schema::dropIfExists('posts_people');
    }
}
