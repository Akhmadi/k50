<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
	const SLUG_SUFFIX = '.html';

	const POST_STATUS_ENABLED = 'ENABLED';
	const POST_STATUS_DISABLED = 'DISABLED';

	protected $table = 'posts';
	protected $metaField = [];

	protected $perPage = 0;

	/********************************** relations *******************************/

	function postType(){
		return $this->belongsTo(PostType::class);
	}

	function postCategory(){
		return $this->belongsTo(PostCategory::class);
	}

	function ratingPersons(){
		return $this->belongsToMany(Person::class, 'posts_people', 'post_id', 'person_id')
					->wherePivot('type', '=', PersonType::PERSON_TYPE_RATING)
		            ->withPivot(['meta', 'type']);
	}

	function forumMembers(){
		return $this->belongsToMany(Person::class, 'posts_people', 'post_id', 'person_id')
					->wherePivot('type', '=', PersonType::PERSON_TYPE_FORUM_MEMBER)
		            ->withPivot(['meta', 'type']);
	}

	function forumPartners(){
		return $this->belongsToMany(Person::class, 'posts_people', 'post_id', 'person_id')
					->wherePivot('type', '=', PersonType::PERSON_TYPE_FORUM_PARTNER)
		            ->withPivot(['meta', 'type']);
	}

	function forumSpeakers(){
		return $this->belongsToMany(Person::class, 'posts_people', 'post_id', 'person_id')
					->wherePivot('type', '=', PersonType::PERSON_TYPE_FORUM_SPEAKER)
		            ->withPivot(['meta', 'type']);
	}

	function timeLines(){
		return $this->hasMany(TimeLine::class);
	}

	function postPackages(){
		return $this->hasMany(PostPackage::class);
	}

	function presentations(){
		return $this->hasMany(Presentation::class);
	}

	function tasks(){
		return $this->hasMany(Task::class);
	}

	function students(){
		return $this->belongsToMany(User::class, 'posts_users', 'post_id', 'user_id')->withPivot(['type', 'status', 'textreject'])->wherePivot('type', '=', 'student');
	}

	function registeredUsers(){
		return $this->belongsToMany(RegEventUser::class, 'reg_event_link_data', 'post_id', 'user_id')
					->withPivot(['meta']);
	}

	/********************************** scopes *******************************/

    function scopeOnlyEnabled($q){
        return $q->where('status', self::POST_STATUS_ENABLED);
    }

	function scopeSlides($q){
		return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_SLIDER )->id);
	}

	function scopeNews($q){
		return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_NEWS )->id);
	}

	function scopeQuestions($q){
		return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_QUESTION )->id);
	}

	function scopeReviews($q){
		return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_REVIEW )->id);
	}

    function scopeResearch($q){
        return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_RESEARCH )->id);
    }

	function scopeRatings($q){
		return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_RATING )->id);
	}

	function scopeEvents($q){
		return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_EVENTS )->id);
	}

	function scopeInitiatives($q){
		return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_INITIAIIVES )->id);
	}

    function scopePartnerProducts($q){
        return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_PARTNER_PRODUCTS )->id);
    }

	function scopeKpro($q){
		return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_KPRO )->id);
	}

    function scopeLife($q){
        return $q->where('post_type_id', PostType::getByCode( PostType::POST_TYPE_LIFE )->id);
    }

	function scopeBySlug($q, $slug){

		if (ends_with($slug, self::SLUG_SUFFIX )) {
			$slug = substr($slug, 0 , strlen($slug) - strlen(self::SLUG_SUFFIX));
		}

		return $q->where('slug', $slug);

	}

	function scopeByText($q, $text){
		return $q
			->whereIn('post_type_id',
				PostType::getByCode( [
						PostType::POST_TYPE_INITIAIIVES,
						PostType::POST_TYPE_EVENTS,
						PostType::POST_TYPE_RATING,
						PostType::POST_TYPE_REVIEW,
						PostType::POST_TYPE_NEWS
					]
				)->pluck('id')
			)
			->where(
				function($q)use($text){
					return $q->where('title', 'like', '%'.$text.'%')->orWhere('excerpt', 'like', '%'.$text.'%');
				}
			);
	}

	function scopeByYear($q, $year){
		return $q->where(DB::Raw('YEAR(event_date)'), $year);
	}

	function scopeByPostCategory($q, $postCatSlug){
		return $q->whereHas('postCategory', function($wq)use($postCatSlug){
			return $wq->where('slug', $postCatSlug);
		});
	}

	/******************************** overrides *************************************/

	public function save( array $options = [] ) {

		if (!$this->user_id) $this->user_id = Auth::user()->id;

		return parent::save( $options );
	}


	/******************************* meta fields ***************************************/

	function getMetaValue($key){

		if (!count($this->metaField)){
			$this->metaField = json_decode($this->meta, true);
		}

		return array_get($this->metaField, $key, '');
	}

	function getEventDateAttribute(){
		return $this->getMetaValue('event.date');
	}

    function getKproStartDateAttribute(){
        return $this->getMetaValue('kpro.start');
    }

    function getKproEndDateAttribute(){
        return $this->getMetaValue('kpro.end');
    }

    function getKproMaxStudentsAttribute(){
        return $this->getMetaValue('kpro.stud_qty');
    }

	function getEventPlaceAttribute(){
		return $this->getMetaValue('event.place');
	}

	function getEventPlaceCoordsAttribute(){
		return $this->getMetaValue('event.place_coords');
	}

	function getEventRegistrationAttribute(){
		return $this->getMetaValue('event.registration');
	}

    function getEventRegistrationMediaAttribute(){
        return $this->getMetaValue('event.registration_media');
    }

    function getGalleryUrlAttribute(){
        return $this->getMetaValue('gallery_url');
    }

	function getEventPresentationAttribute(){
		return $this->getMetaValue('event.presentation');
	}

	function getEventVideoAttribute(){
		return $this->getMetaValue('event.video');
	}

	function getEventPhotosAttribute(){
		return $this->getMetaValue('event.photo');
	}

	function getEventPhotosUrlAttribute(){
		return $this->getMetaValue('event.photo_url');
	}

	function getEventMemberFormAttribute(){
		return $this->getMetaValue('event.become_member_form');
	}

    function getEventMediaFormAttribute(){
        return $this->getMetaValue('event.become_media_form');
    }

	function getEventRegistrationStatusAttribute(){
		return $this->getMetaValue('event.registration');
	}

    function getEventRegistrationMediaStatusAttribute(){
        return $this->getMetaValue('event.registration_media');
    }

	function getKproProgramUrl(){
		return $this->getMetaValue('kpro.program_url');
	}

    function getKproRegisterOpenedAttribute(){

        $start = $this->getMetaValue('kpro.start');
        $end = $this->getMetaValue('kpro.end');
        $studQty = $this->getMetaValue('kpro.stud_qty');

        if($start && $end && $studQty) {

            if ((Carbon::now()->gte( $start )) && (Carbon::now()->lte($end))){

                return $this
                        ->students()
                        ->wherePivot('status', '=', 'enabled')
                        ->get()->count() < $studQty;
            } else {
                return false;
            }
        } else {
            return false;
        }
	}
	
	function getSobytiyaRegisterOpenedAttribute(){
		$eventReg = $this->getMetaValue('event.registration');
		$eventDate = new Carbon($this->getMetaValue('event.date'));
		$dayBefore = $this->getMetaValue('event.days_before_start');
		$maxUsers = $this->getMetaValue('event.max_memebrs_count');
		$cntUsers = $this->registeredUsers()->count();
		

		if ($eventReg != 'ENABLED'){
			return false;
		} else {
			if (Carbon::now()->lte($eventDate->subDays($dayBefore))){
				if ($cntUsers < ($maxUsers)){
					return true;
				} else {
					return false;
				}				
			} else {
				return false;
			}
			
		}
	}

	function getUrlAttribute(){
		if (($this->postType->code != PostType::POST_TYPE_REVIEW) && ($this->postType->code != PostType::POST_TYPE_RESEARCH) && $this->slug){

		    if (($this->postType->code == PostType::POST_TYPE_NEWS) && starts_with($this->slug, 'http')) {
		        return url($this->slug);
            } else {
                return url(PagesService::pageRoute($this->postType->page, ['slug' => $this->slug.self::SLUG_SUFFIX]));
            }
		} else {
			return url($this->slug);
		}
	}

	function getPhraseTextAttribute(){
		return $this->getMetaValue('phrase.text');
	}

    function getLifeImagesAttribute(){
        return $this->getMetaValue('studentlife.images');
    }

    function getLifeVideosAttribute(){
        return $this->getMetaValue('studentlife.videos');
    }

	function getPhraseImageAttribute(){
		return $this->getMetaValue('phrase.image');
	}

	function getCreatedAttribute(){

	    return getFormattedDate($this->created_at);
    }
}
