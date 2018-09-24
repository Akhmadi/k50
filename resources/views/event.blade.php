@extends('layouts.page')

@php

    $action = request()->query('action', false);

    if ($post = \App\Post::events()->onlyEnabled()->bySlug($params['slug']['value'])->first()){

        App\Post::where('id', $post->id)->increment('views');

        $coords = explode(',', $post->eventPlaceCoords);

        if (count($coords) == 2){
            $lat = $coords[0];
            $lng = $coords[1];
        }

        /* if ($action == 'register'){
            $eventFormScript = prepareFormScript($post->eventMemberForm, 'bform');
        */
        if ($action == 'registermedia'){
            $eventFormScript = prepareFormScript($post->eventMediaForm, 'bform');
        }

        $regUsers = \App\RegEventUser::all();

        $eventPhotos = crud_image($post->eventPhotos, true);
        $eventPhotoCount = count($eventPhotos);

    }

    $posts = \App\Post::events()->onlyEnabled()->orderBy('id', 'desc')->take(6)->get();
@endphp

@section('og')
    @if($post)
        <meta property="og:url"                content="{{ url()->current() }}" />
        <meta property="og:type"               content="article" />
        <meta property="og:title"              content="{{ $post->title }}" />
        <meta property="og:description"        content="{{ $post->excerpt }}" />
        <meta property="og:image"              content="{{ url($post->image) }}" />
    @endif
@endsection

@section('page_content')
    <div class="section event__post__section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    @if(isset($post))
                        <div class="block">
                            <div class="block__header mar-5-xs mar-0-md">
                                <div class="title">{{ $post->title }}</div>
                            </div>

                            <div class="block__content event__post">
                                <div class="title__image image__wrapper">
                                    <img src="{{ $post->image ? url($post->image) : '' }}" alt="{{ $post->title }}">
                                </div>
                                <div class="row description pad-5-xs pad-0-md">
                                    <div class="col-xs-6 stats">
                                        <span class="date">{{ $post->created }}</span>
                                        <span class="views">{{ $post->views }}</span>
                                    </div>
                                    <ul class="col-xs-6 socials">
                                        <li class="socials__item">
                                            <a class="share-data" role="button"
                                               data-url="{{ $post->url }}"
                                               data-provider="facebook"
                                               data-title="{{ $post->title }}"
                                               data-image="{{ url($post->image) }}"
                                               data-desc="{{ $post->excerpt }}"><i class="icon icon-facebook"></i></a>
                                        </li>
                                        <li class="socials__item">
                                            <a class="share-data" role="button"
                                               data-provider="twitter"
                                               data-url="{{ $post->url }}"
                                               data-title="{{ $post->title }}"
                                               data-image="{{ url($post->image) }}"
                                               data-desc="{{ $post->excerpt }}"><i class="icon icon-twitter"></i></a>
                                        </li>
                                        <li class="socials__item">
                                            <a class="share-data" role="button"
                                               data-provider="linkedin"
                                               data-url="{{ $post->url }}"
                                               data-title="{{ $post->title }}"
                                               data-image="{{ url($post->image) }}"
                                               data-desc="{{ $post->excerpt }}"><i class="icon icon-linkedin"></i></a>
                                        </li>

                                    </ul>
                                </div>

                                @if($action == 'register' || $action == 'registermedia')
                                    <div class='row col-xs-12'>
                                        @include('event_form_registration')
                                    </div>                                    

                                    <div class="ta-center-xs pad-20-xs">
                                        <a href="{{ url()->current() }}" class="btn is__red is__margined">Назад к событию</a>
                                    </div>
                                @else

                                    <div class="info row between-xs middle-xs">
                                        <div class="col-xs  pad-5-xs pad-0-md">
                                            <p><b>Дата: </b>{{ $post->eventDate }}</p>
                                            <p><b>Место: </b>{{ $post->eventPlace }}</p>
                                        </div>
                                        <div class="col-xs-12 col-md-4 center-xs end-md  pad-5-xs pad-0-md">
                                            @if($post->eventRegistrationStatus == 'ENABLED')
                                                <a href="{{ url()->current() .'?'. http_build_query(['action' => 'register']) }}" class="btn is__red is__margined">Стать участником</a>
                                            @else
                                                <p>Регистрация закрыта</p>
                                            @endif

                                            @if($post->eventRegistrationMediaStatus == 'ENABLED')
                                                <a href="{{ url()->current() .'?'. http_build_query(['action' => 'registermedia']) }}" class="btn is__red is__margined">Аккредитация СМИ</a>
                                            @else
                                                <p>Аккредитация СМИ закрыта</p>
                                            @endif

                                            {{--@if($post->eventRegistrationStatus == 'ENABLED')--}}
                                            {{--<a href="javascript:;" data-modalclass=".event__member__form" class="btn is__red is__margined js-toggle-modal">Стать участником</a>--}}
                                            {{--@else--}}
                                            {{--<p>Регистрация закрыта</p>--}}
                                            {{--@endif--}}
                                        </div>
                                    </div>

                                    <div class="content pad-5-xs pad-0-md">
                                        {!! $post->body !!}
                                    </div>

                                    <div class="tabs">
                                        <div class="tab__header">
                                            <span class="tab btn is__active is__active_red has__icon " data-tab-id="2"><img src="{{ url('/images/file.png') }}" alt="">Программа</span>
                                            <span class="tab btn is__active_red has__icon " data-tab-id="3"><img src="{{ url('/images/info.png') }}" alt="">Партнеры</span>
                                            <span class="tab btn is__active_red has__icon " data-tab-id="4"><img src="{{ url('/images/microphone.png') }}" alt="">Спикеры</span>
                                            <span class="tab btn is__active_red has__icon " data-tab-id="6"><img src="{{ url('/images/galery.png') }}" alt="">Галерея</span>
                                        </div>
                                        <div class="tab__content">
                                            <div class="tab is__active" data-tab-id="2">
                                                @if($post->eventPresentation)
                                                    <a href="{{ $post->eventPresentation ? url($post->eventPresentation) : ''}}" target="_blank" class="link pad-5-xs pad-0-md" download>Скачать программу</a>
                                                @endif
                                                <div class="program__plan pad-5-xs pad-0-md">
                                                    <div class="plan__row title">
                                                        <div class="plan-col-1">Время</div>
                                                        <div class="plan-col-2"></div>
                                                        <div class="plan-col-3">План</div>
                                                    </div>
                                                    <div class="program__plan_body">
                                                        @foreach($post->timeLines as $timeLine)
                                                            <div class="plan__row">
                                                                <div class="plan-col-1">{{ $timeLine->planned_time }}</div>
                                                                <div class="plan-col-2">
                                                                    <div class="dot"></div>
                                                                </div>
                                                                <div class="plan-col-3">{!! $timeLine->planned_part !!}</div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                @if(isset($lat) && isset($lng))
                                                    <div class="map mt-20-xs" ></div>
                                                @endif
                                            </div>
                                            <div class="tab" data-tab-id="3">
                                                <div class="partners">
                                                    @foreach($post->forumPartners as $partner)
                                                        <div class="partner pad-5-xs">
                                                            <a href="{{ $partner->partnerUrl }}" target="_blank">
                                                                <div class="image__wrapper ">
                                                                    <img src="{{ $partner->image ? url($partner->image) : '' }}" alt="{{ $partner->name }}">
                                                                </div>
                                                                <p>{{ $partner->name}}</p>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            <div class="tab" data-tab-id="4">
                                                <div class="speakers">
                                                    @foreach($post->forumSpeakers->chunk(3) as $chunk)
                                                        <div class="row mb-20-xs">
                                                            @foreach($chunk as $speaker)
                                                                <div class="col-xs-12 col-md-4 col speaker">
                                                                    <div class="row pos-relative-xs h-auto-xs frame-border hidden-xs flex-md">
                                                                        <div class="col-md-6 pos-relative-xs h-150px-xs center-xs mt-10-xs mt-5-sm mb-5-sm ">
                                                                            <img src="{{ $speaker->image ? url($speaker->image) : '' }}" alt="{{ $speaker->name }}" class="img-by-h-xs pos-absolute-xs">
                                                                        </div>    
                                                                        <div class="col-md-6 info mt-5-sm">
                                                                            <p class="fw-700-xs fs-12-xs color-black">{{ $speaker->name}}</p>
                                                                            <p class="fw-300-xs fs-12-xs color-black mt-20-xs">{{ $speaker->position}}</p>
                                                                        </div>
                                                                        <div class="bio col-xs-12">
                                                                            <p class=" fs-12-xs pad-5-xs ">{{ $speaker->info}}</p>
                                                                            @if($speaker->press)
                                                                                <div class="ta-center-xs presentation-button">
                                                                                    <a href="{{ url($speaker->press) }}" target="_blank" class="link">Скачать презентацию</a>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>    
                                                                                                                                    
                                                                    <div class="info hidden-md flex-xs row">
                                                                        <div class="col-xs-12 mt-10-xs">
                                                                            <img src="{{ $speaker->image ? url($speaker->image) : '' }}" alt="{{ $speaker->name }}" class="inline-block-xs w-50-xs block-xs ml-auto-xs mr-auto-xs">
                                                                            <p class="fw-700-xs fs-14-xs pl-5-xs color-black ta-center-xs">{{ $speaker->name}}</p>
                                                                        </div>
                                                                        <div class="col-xs-12">
                                                                            <p class="fw-300-xs fs-12-xs pl-5-xs color-black ta-center-xs">{{ $speaker->position}}</p>
                                                                        </div>
                                                                        <div class="hidden-md">
                                                                            <p class="fs-12-xs pad-5-xs ta-justify-xs color-black">{{ $speaker->info}}</p>
                                                                            @if($speaker->press)
                                                                                <div class="ta-center-xs presentation-button">
                                                                                    <a href="{{ url($speaker->press) }}" target="_blank" class="link">Скачать презентацию</a>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                            {{--<div class="tab" data-tab-id="5">--}}
                                            {{--<h5>Презентация</h5>--}}
                                            {{--<a href="{{ url($post->eventPresentation) }}"  class="btn is__outlined">Скачать презентацию</a>--}}
                                            {{--</div>--}}
                                            <div class="tab" data-tab-id="6">
                                                @if($post->eventPhotosUrl)
                                                    <a href="{{ $post->eventPhotosUrl }}" target="_blank" class="link">Ссылка на полную галерею</a>
                                                @endif
                                                <div class="row center-xs">
                                                    @if ($eventPhotoCount)
                                                        <div class="row col-xs-12">
                                                            @foreach(array_chunk($eventPhotos, ceil($eventPhotoCount / 3) ) as $chunk)
                                                                <div class="col-xs-12 col-md-4 padded-5 fsz-0">
                                                                    @foreach($chunk as $image)
                                                                        <div class="image__wrapper mb-5 ovr-h br-5"><img src="{{ url($image) }}" alt="{{ $post->title }}"></div>
                                                                    @endforeach
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                    @else
                                                        @if(!$post->eventPhotosUrl)
                                                        <p>Фото будут опубликованы после мероприятия</p>
                                                        @endif
                                                    @endif
                                                </div>
                                                @if($post->eventVideo)
                                                    {!! $post->eventVideo !!}
                                                    {{--<video class="video-container video-js vjs-default-skin" controls preload="none">--}}
                                                    {{--<source src="{{ $post->eventVideo }}" type='video/mp4'>--}}
                                                    {{--</video>--}}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>
                        </div>
                    @else
                        <p>Ничего не найдено</p>
                    @endif
                </div>
                <div class="col-xs-12 col-md-4 sidebar sidebar_right">
                    <div class="block pad-5-xs pad-0-md">
                        <div class="block__header">
                            <div class="title">Другие события</div>
                        </div>

                        <div class="block__content row">
                            @foreach( $posts as $post)
                                <div class="col-xs-12 ">
                                    <div class="pointed-list-item">
                                        <div class="point"></div>
                                        <div class="content row between-xs end-xs">
                                            <p class="date">{{ getFormattedDate($post->eventDate) }}</p>
                                            <p class="views">{{ $post->views }}</p>
                                            <p class="text col-xs-12">{{ $post->title }}</p>
                                        </div>
                                        <a href="{{ $post->url }}" title="{{$post->title}}" class="pointed-list-item__url"></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            {{--<div class="modal event__member__form" >--}}
                {{--<div class="modal-header pad-10-xs">--}}
                    {{--<a href="javascript:;" class="close-button">--}}
                        {{--<i data-modalclass=".event__member__form" class="icon icon-cancel js-toggle-modal pos-relative-xs"></i>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="modal-content h-100-xs">--}}
                    {{--<div id="bform" class="bform h-100-xs"></div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection


@section('scripts')
    @parent

    {!! isset($eventFormScript) ? $eventFormScript : '' !!}

    @if(isset($lat) && isset($lng))
        <script>
            function initMap() {

                elMap = document.querySelector('.map');
                if (elMap) {
                    var uluru = {lat: {{ $lat }}, lng: {{ $lng }} };
                    var map = new google.maps.Map(elMap, {
                        zoom: 14,
                        center: uluru
                    });
                    var marker = new google.maps.Marker({
                        position: uluru,
                        map: map
                    });
                }

            }
        </script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAA6eTSNtTGtTOnvOIah6c4Eimcmqd9Znc&callback=initMap">
        </script>
    @endif
@endsection
