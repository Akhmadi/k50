<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    function postType(){
    	return $this->belongsTo(PostType::class);
    }

    function scopeEnabled($q){

        return $q->where('status', 'ENABLED');
    }

    function scopeByPostType($q, $postType){

    	if ($postType) {
		    return $q->wherePostTypeId(is_array($postType) ? $postType['id'] : $postType->id);
	    }

	    return $q;
	}

	function scopeByPostTypeCode($q, $postTypeCode){

		if ($postTypeCode) {
			return $q->whereHas('postType', function($q)use($postTypeCode){
				return $q->where('code', $postTypeCode);
			});
		}

		return $q;
	}
}
