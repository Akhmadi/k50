<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->unsigned();
            $table->string('title');
            $table->string('file');
            $table->date('begin_at');
	        $table->string('start_time');
	        $table->string('end_time');
	        $table->integer('post_id')->unsigned()->nullable();
	        $table->foreign('post_id', 'foreign_tasks_post_id')
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
        Schema::dropIfExists('tasks');
    }
}
