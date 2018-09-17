@extends('layouts.page')

@php
    $guest = \Illuminate\Support\Facades\Auth::guest();

    $slug = $params['slug']['value'];
    $item = null;

    if ($slug ){

        if ($item = \App\Post::life()->where('status', 'enabled')->bySlug($slug)->first()){
            $images = crud_image($item->lifeImages, true);
            $imagesCount = count($images);
        } else {
           redirect_now( page_route('studentlife'));
        }

    } else {


        $items = \App\Post::life()->where('status', 'enabled')->get();
    }

    $kpro = null;
    $kproOpened = false;

    if ($guest){

        if ($kpro = \App\Post::kpro()->where('status', \App\Post::POST_STATUS_ENABLED)->first())
            $kproOpened = $kpro->kproRegisterOpened;

    }


@endphp

@section('page_content')

    <div class="section life__section kpro__section is__paddingless">
        <div class="image__wrapper title__image">
            <div class="container">
                <div class="row col-xs-12 between-md mb-20-xs mb-80-md">
                    <div class="col-xs-12 col-md center-xs start-md">
                        <img src="{{ crud_image(crud_settings('site.kpro_logo')) ? url( crud_image(crud_settings('site.kpro_logo')) , false) : ''}}" alt="" class="kpro__logo">
                    </div>
                    <div class="col-xs-12 col-md row center-xs end-md mt-20-xs mt-0-md">
                        <div class="kpro_steps row between-xs pl-5-xs pl-0-md pr-5-xs pr-0-md">
                            <span class="kpro_steps__item"><a class="link" href="{{ page_route('k_pro_postuplenie') }}">поступление</a></span>
                            <span class="kpro_steps__item"><a class="link" href="{{ page_route('studentlife') }}">student life</a></span>
                            <span class="kpro_steps__item">обучение</span>
                        </div>
                    </div>

                </div>
                @if($guest)
                    <div class="row col-xs-12 center-xs title_actions row  mb-20-xs mb-0-md">
                        <a href="{{ \App\PagesService::pageRoute('kpro_login') }}"
                           class="btn is__red width_240px is__rounded" >Войти</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="container">
            <div class="block_content">
                <div class="block__header mar-5-xs mar-0-md">
                    <p class="title">{{ $slug && $item ? $item->title : 'student life' }}</p>
                </div>
                @if($item && $item->galleryUrl)
                <div class="row mar-20-xs center-xs">
                    <a href="{{ $item->galleryUrl }}" target="_blank" class="link fs-16-xs">Ссылка на полную галерею</a>
                </div>
                @endif

                <div class="block_content row center-md pad-5-xs pad-0-md">
                    @if($item)
                        <div class="col-xs-12 gallery">
                            <div class="col-xs-12 col-md-3 gallery_sizer"></div>
                            @foreach($images as $image)
                            <div class="gallery_item padded-5 fsz-0 image__wrapper mb-5 ovr-h br-5">
                                <img src="{{ url($image) }}" alt="{{ $item->title }}">
                            </div>
                            @endforeach
                        </div>

                        <div class="row col-xs-12 center-md">
                            @foreach(crud_image($item->lifeVideos, true) as $video)
                            <div class="col-xs-12 col-md-6 section video__wrapper">
                                <video id="my_video_1" class="video-container video-js vjs-default-skin" controls preload="none">
                                    <source src="{{ $video }}" type='video/mp4'>
                                </video>
                            </div>
                            @endforeach
                        </div>

                    @else
                        @foreach($items as $item)
                            <div class="col-xs-12 col-md-3 card ">
                                <div class="image__wrapper">
                                    <img src="{{ url($item->image) }}" alt="{{ $item->title }}">
                                </div>
                                <div class="card__footer row col center-xs middle-xs">
                                    <p class="date">{{ $item->created }}</p>
                                    <p class="title">{{$item->title}}</p>
                                </div>
                                <a href="{{ $item->url ? url($item->url) : 'javascript:;' }}" title="{{$item->title}}"></a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection

