<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('name');
	        $table->string('image');
	        $table->integer('person_type_id')->unsigned();

	        $table->foreign('person_type_id', 'foreign_people_person_type_id' )
	              ->references('id')
	              ->on('person_types');

	        $table->json('meta')->nullable();
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
	    Schema::create('people', function (Blueprint $table) {
		    $table->dropForeign('foreign_people_person_type_id');
	    });

        Schema::dropIfExists('people');
    }
}
