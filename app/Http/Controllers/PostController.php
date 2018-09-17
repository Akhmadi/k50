<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
	function getViewByCat($cat){
		$cats = array( 'iniciativa' => 'iniciativa', 'sobytiya' => 'sobytiya', 'obzory' => 'obzory', 'oprosniki' => 'oprosniki');
		return $cats[$cat];
	}



    function getPosts($category){

		return view($this->getViewByCat($category));
    }

	function getPost($category, $slug){
		return view($this->getViewByCat($category));
	}
}
