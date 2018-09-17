<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PersonType extends Model
{
	const PERSON_TYPE_RATING = 'ratings';
	const PERSON_TYPE_FORUM_MEMBER = 'forum_members';
	const PERSON_TYPE_FORUM_PARTNER = 'forum_partners';
	const PERSON_TYPE_FORUM_SPEAKER = 'forum_speakers';
    const PERSON_TYPE_TEAM = 'team';

	public static function getByCode($code){
		return self::where('code', $code)->first();
	}
}
