<?php
/**
 * Created by PhpStorm.
 * User: dr_sharp
 * Date: 17.03.2018
 * Time: 21:40
 */

if (!function_exists('getPostTypeSlider')){
    function getPostTypeSlider(){
        return \App\PostType::getByCode( App\PostType::POST_TYPE_SLIDER )->toArray();
    }
}

if (!function_exists('getPostTypeNews')){
    function getPostTypeNews(){
        return \App\PostType::getByCode( \App\PostType::POST_TYPE_NEWS )->toArray();
    }
}

if (!function_exists('getPostTypeQuestion')){
    function getPostTypeQuestion(){
        return \App\PostType::getByCode( \App\PostType::POST_TYPE_QUESTION )->toArray();
    }
}

if (!function_exists('getPostTypeInitiative')){
    function getPostTypeInitiative(){
        return \App\PostType::getByCode( \App\PostType::POST_TYPE_INITIAIIVES )->toArray();
    }
}

if (!function_exists('getPostTypeResearch')){
    function getPostTypeResearch(){
        return \App\PostType::getByCode( \App\PostType::POST_TYPE_RESEARCH )->toArray();
    }
}


if (!function_exists('getPostTypePartnerProducts')){
    function getPostTypePartnerProducts(){
        return \App\PostType::getByCode( \App\PostType::POST_TYPE_PARTNER_PRODUCTS )->toArray();
    }
}



if (!function_exists('getPostTypeReview')){
    function getPostTypeReview(){
        return \App\PostType::getByCode( \App\PostType::POST_TYPE_REVIEW )->toArray();
    }
}

if (!function_exists('getPostTypeRating')){
    function getPostTypeRating(){
        return \App\PostType::getByCode( \App\PostType::POST_TYPE_RATING )->toArray();
    }
}

if (!function_exists('getPostTypeEvent')){
    function getPostTypeEvent(){
        return \App\PostType::getByCode( \App\PostType::POST_TYPE_EVENTS )->toArray();
    }
}

if (!function_exists('getPostTypeKpro')){
    function getPostTypeKpro(){
        return \App\PostType::getByCode( \App\PostType::POST_TYPE_KPRO )->toArray();
    }
}

if (!function_exists('getPostTypeLife')){
    function getPostTypeLife(){
        return \App\PostType::getByCode( \App\PostType::POST_TYPE_LIFE )->toArray();
    }
}

if (!function_exists('getPersonTypeForumSpeaker')){
    function getPersonTypeForumSpeaker(){
        return \App\PersonType::getByCode(App\PersonType::PERSON_TYPE_FORUM_SPEAKER);
    }
}

if (!function_exists('getPersonTypeForumPartner')){
    function getPersonTypeForumPartner(){
        return \App\PersonType::getByCode(App\PersonType::PERSON_TYPE_FORUM_PARTNER);
    }
}

if (!function_exists('getPersonTypeTeam')){
    function getPersonTypeTeam(){
        return \App\PersonType::getByCode(App\PersonType::PERSON_TYPE_TEAM);
    }
}

if (!function_exists('getPersonTypeForumMember')){
    function getPersonTypeForumMember(){
        return \App\PersonType::getByCode(App\PersonType::PERSON_TYPE_FORUM_MEMBER);
    }
}

if (!function_exists('getPersonTypeRatings')){
    function getPersonTypeRatings(){
        return \App\PersonType::getByCode(App\PersonType::PERSON_TYPE_RATING);
    }
}

if (!function_exists('data_team_members')){
    function data_team_members(){
        return \App\Person::team()->get();
    }
}


if (!function_exists('getFormattedDate')){
    function getFormattedDate($date, $type = ''){

        if (!$date) return;

        if (is_string($date)) {

            $date = \Carbon\Carbon::createFromFormat('Y-m-d', $date);

        }

        $monthes = [
            'ru' => [
                'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля',
                'августа', 'сентября', 'октября', 'ноября', 'декабря'
            ]
        ];

        if ($type == '') {
            return sprintf('%s %s, %s', $date->day, $monthes['ru'][$date->month - 1], $date->year);
        }

        if ($type == 'short') {
            return sprintf('%s %s', $date->day, $monthes['ru'][$date->month - 1]);
        }

    }
}


if (!function_exists('getPastEvents')) {
    function getPastEvents()
    {
        $items = collect();

        foreach (\App\Post::with('postType.page')->events()->onlyEnabled()->orderBy('id', 'desc')->get() as $item) {
            if (\Carbon\Carbon::now()->gte($item->eventDate)){

                $items->push($item);
            }
        }

        return $items;
    }
}

if (!function_exists('getFeatureEvents')) {
    function getFeatureEvents()
    {
        $items = collect();

        foreach (\App\Post::with('postType.page')->events()->onlyEnabled()->get() as $item) {

            if (\Carbon\Carbon::now()->lte($item->eventDate)){
                $items->push($item);
            }
        }

        $items = $items->sortBy('eventDate');

        return $items;
    }
}

if (!function_exists('getRandomPhrases')) {
    function getRandomPhrases($qty = 5)
    {
        $items = collect();

        foreach (\App\Post::news()->onlyEnabled()->whereNotNull('meta')->inRandomOrder()
                     ->get() as $item) {

            if ($item->phraseText){
                $items->push($item);
            }

            if($items->count() == $qty) break;
        }

        return $items;
    }
}