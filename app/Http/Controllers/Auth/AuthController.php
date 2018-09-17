<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Services\SocialAccountService;

class AuthController extends Controller
{
	/**
	 * Redirect the user to the GitHub authentication page.
	 *
	 * @return Response
	 */
	public function redirectToProvider($provider)
	{
		Session::put('callback_url', request('callback_url', 'home'));

		return Socialite::driver($provider)->redirect();
	}

	/**
	 * Obtain the user information from GitHub.
	 *
	 * @return Response
	 */
	public function handleProviderCallback(SocialAccountService $socialService, $provider)
	{
		$user = $socialService->getUserBySocialAccount(Socialite::driver($provider), $provider);

		Auth::login($user, true);

		return Redirect::to(Session::get('callback_url',route('home')));
	}

	function getLogin(){
		if (!Auth::guest()) {
			return Redirect::route('home', App::getLocale());
		}

		return View::make('pages.login');
	}

	function postLogin(){

	}
}
