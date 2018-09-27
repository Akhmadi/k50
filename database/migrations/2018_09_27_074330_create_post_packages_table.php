<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_packages', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('post_id')->unsigned()->nullable();

	        $table->foreign('post_id', 'foreign_post_packages_post_id')
	              ->references('id')
	              ->on('posts')
                  ->onDelete('cascade');
            
            $table->string('order');
            $table->string('title');
            $table->string('amount');
            $table->text('desc')->nullable();                  
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
        Schema::table('post_packages', function (Blueprint $table) {
		    $table->dropForeign('foreign_post_packages_post_id');
        });
        
        Schema::dropIfExists('post_packages');
    }
}
