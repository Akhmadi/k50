<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentations', function (Blueprint $table) {
            $table->increments('id');
            $table->date('begin_at');
            $table->string('title');
            $table->string('url')->nullable();
	        $table->integer('post_id')->unsigned()->nullable();
	        $table->foreign('post_id', 'foreign_presentations_post_id')
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
	    Schema::table('presentations', function (Blueprint $table) {
		    $table->dropForeign('foreign_presentations_post_id');
	    });

        Schema::dropIfExists('presentations');
    }
}
