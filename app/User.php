<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Vshapovalov\Crud\Models\Role;

class User extends Authenticatable
{

	protected $metaField = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	/**
	 * Creating user by social account's data
	 *
	 * @param ProviderUser $providerUser
	 */
	public static function createBySocialProvider(ProviderUser $providerUser){
		self::create([
			'name' => $providerUser->getName(),
			'email' => $providerUser->getEmail(),
			'password' => $providerUser->getId()
		]);
	}

//	function role(){
//		return $this->belongsTo(Role::class);
//	}

	function getMetaValue($key){

		if (!count($this->metaField)){
			$this->metaField = json_decode($this->meta, true);
		}

		return array_get($this->metaField, $key, '');
	}

	function getFirstNameAttribute(){
		return $this->getMetaValue('firstname');
	}


	function getLastNameAttribute(){
		return $this->getMetaValue('lastname');
	}

	function getPatronymicAttribute(){
		return $this->getMetaValue('patronymic');
	}


	function getPhoneMobileAttribute(){
		return $this->getMetaValue('phone_mobile');
	}

	function scopeStudents($q){
	    return $q->where('type','student');
    }

    function scopeNotStudents($q){
        return $q->where('type', '<>', 'student')->orWhereNull('type');
    }

}
