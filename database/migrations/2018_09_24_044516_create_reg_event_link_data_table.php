<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegEventLinkDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_event_link_data', function (Blueprint $table) {
            $table->integer('post_id')->unsigned();

            $table->foreign('post_id','foreign_reg_event_users_post_id')
                    ->references('id')
                    ->on('posts')
                    ->onDelete('cascade');
            
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id','foreign_reg_event_users_user_id')
                    ->references('id')
                    ->on('reg_event_users')
                    ->onDelete('cascade');
            
            $table->text('meta')->nullable();
            
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
        Schema::table('reg_event_link_data', function (Blueprint $table) {
	    	$table->dropForeign('foreign_reg_event_users_post_id');
		    $table->dropForeign('foreign_reg_event_users_user_id');
	    });
        Schema::dropIfExists('reg_event_link_data');
    }
}
