<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->increments('id');
	        $table->integer('user_id')->unsigned();
	        $table->foreign('user_id')
		        ->references('id')
		        ->on('users')
		        ->onDelete('cascade');
	        $table->string('provider');
	        $table->string('provider_user_id');
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
	    Schema::table('social_accounts', function (Blueprint $table) {
		    $table->dropForeign('social_accounts_user_id_foreign');
	    });

        Schema::dropIfExists('social_accounts');
    }
}
