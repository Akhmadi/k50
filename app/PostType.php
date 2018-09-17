<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class PostType extends Model
{
	const POST_TYPE_SLIDER = 'sliders';
	const POST_TYPE_NEWS = 'news';
	const POST_TYPE_QUESTION = 'questions';
	const POST_TYPE_RATING ='ratings';
	const POST_TYPE_REVIEW = 'reviews';
    const POST_TYPE_RESEARCH = 'research';
	const POST_TYPE_INITIAIIVES = 'initiatives';
    const POST_TYPE_PARTNER_PRODUCTS = 'partner_products';
	const POST_TYPE_EVENTS = 'events';
	const POST_TYPE_KPRO = 'kpro';
    const POST_TYPE_LIFE = 'life';

	/**
	 * @param $code string|array
	 *
	 * @return mixed
	 */
	public static function getByCode($code){
		$postTypesCollection = Cache::remember('postTypes', 180, function(){
			return self::all();
		});

		if (is_array($code)) {
			return $postTypesCollection->whereIn('code', $code);
		} else {
			return $postTypesCollection->where('code', $code)->first();
		}
	}

	function posts(){
		return $this->hasMany(Post::class);
	}

	function page(){
		return $this->belongsTo(Page::class);
	}
}
