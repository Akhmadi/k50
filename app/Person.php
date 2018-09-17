<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $table = 'people';

    private $metaField = [];
	private $pivotMetaField = [];

	function scopeRatings($q){
		return $q->wherePersonTypeId( PersonType::getByCode(PersonType::PERSON_TYPE_RATING)->id);
	}

	function personType(){
		return $this->belongsTo(PersonType::class);
	}

	function scopeForumMembers($q){
		return $q->wherePersonTypeId( PersonType::getByCode(PersonType::PERSON_TYPE_FORUM_MEMBER)->id);
	}

    function scopeTeam($q){
        return $q->where('person_type_id',  PersonType::getByCode(PersonType::PERSON_TYPE_TEAM)->id);
    }

	function scopeForumSpeakers($q){
		return $q->wherePersonTypeId( PersonType::getByCode(PersonType::PERSON_TYPE_FORUM_SPEAKER)->id);
	}
	function scopeForumPartners($q){
		return $q->wherePersonTypeId( PersonType::getByCode(PersonType::PERSON_TYPE_FORUM_PARTNER)->id);
	}

	function getMetaValue($key){

		if (!count($this->metaField)){
			$this->metaField = json_decode($this->meta, true);
		}

		return array_get($this->metaField, $key, '');
	}

	function getPivotMetaValue($key){

		if (!count($this->pivotMetaField)){
			$this->pivotMetaField = json_decode($this->pivot->meta, true);
		}

		return array_get($this->pivotMetaField, $key, '');
	}

    function getSubjectAttribute(){
        return $this->getPivotMetaValue('subject');
    }

    function getPressAttribute()
    {
        return $this->getPivotMetaValue('presentation');
    }

    function getInfoAttribute(){
        return $this->getMetaValue('info');
    }

    function getPhoneAttribute(){
        return $this->getMetaValue('phone');
    }

    function getEmailAttribute(){
        return $this->getMetaValue('email');
    }

	function getPositionAttribute(){
        return $this->getMetaValue('position');
    }

	function getPartnerUrlAttribute(){
		return $this->getMetaValue('site_url');
	}

	function getRatingPivotAttribute(){
		return $this->getPivotMetaValue('rating');
	}

	function getDescriptionPivotAttribute(){
		return $this->getPivotMetaValue('description');
	}



}
