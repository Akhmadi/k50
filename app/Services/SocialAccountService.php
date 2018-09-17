<?php
/**
 * Created by PhpStorm.
 * User: dr_sharp
 * Date: 23.08.2017
 * Time: 21:14
 */

namespace App\Services;

use App\SocialAccount;
use App\User;
use Laravel\Socialite\Contracts\Provider as Provider;

/**
 * managing social accounts
 *
 * Class SocialAccountService
 * @package App\Services
 */
class SocialAccountService {

	/**
	 * Getting User by SocialAccount or creating new one by provider user
	 *
	 * @param Provider $provider
	 * @param $providerName
	 *
	 * @return null|User
	 */
	public function getUserBySocialAccount(Provider $provider, $providerName){

		$providerUser = $provider->user();

		if ($providerUser) {

			$socialAccount = SocialAccount::whereProvider($providerName)
			    ->whereProviderUserId($providerUser->getId())
				->first();

			if ($socialAccount) {
				return $socialAccount->user()->first();
			} else {
				$socialAccount = new SocialAccount( [
					'provider_user_id' => $providerUser->getId(),
					'provider'    => $providerName
				] );

				$user = User::whereEmail( $providerUser->getEmail() )
				            ->first();

				if ( ! $user ) {
					$user = User::createBySocialProvider( $providerUser );
				}

				$socialAccount->user()->associate( $user );
				$socialAccount->save();

				return $user;

			}
		}

		return null;
	}

}