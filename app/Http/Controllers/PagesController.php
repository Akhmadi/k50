<?php

namespace App\Http\Controllers;

use App\Page;
use App\PagesService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class PagesController extends Controller
{

	function getIndex(){
		return view('welcome');
	}

    function getPage($page){

	    if ($route = PagesService::getRouteByUrl($page)) {

	        return view(
		        $route['page']->template,
		        [
			        'page' => $route['page'],
			        'params' => isset($route['info']['params']) ? $route['info']['params'] : []
		        ]
	        );
	    } else {

	    	return view('404');
	    }
    }
}
