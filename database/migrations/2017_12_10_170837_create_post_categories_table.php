<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_categories', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('title');
	        $table->string('status');
	        $table->integer('post_type_id')->unsigned();
	        $table->foreign('post_type_id', 'foreign_post_categories_post_type_id')
	              ->references('id')
	              ->on('post_types');

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
	    Schema::table('post_categories', function (Blueprint $table) {
		    $table->dropForeign('foreign_post_categories_post_type_id');
	    });

        Schema::dropIfExists('post_categories');
    }
}
