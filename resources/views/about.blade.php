@extends('layouts.page')

@php
    $speakers = \App\Person::forumSpeakers()->take(20)->get();
    $partners = \App\Person::forumPartners()->take(20)->get();


    $speakerFormScript = false;
    $partnerFormScript = false;

    if($page->code == 'become_speaker'){
        $speakerFormScript = crud_settings('site.speaker_form');

        if($speakerFormScript){
            $speakerFormScript  = prepareFormScript($speakerFormScript , 'bform');
        }
    }


    if($page->code == 'initiatives'){

        $posts = \App\Post::initiatives()->onlyEnabled()->orderBy('id', 'desc')->get();

    }

    if($page->code == 'become_partner'){
        $partnerFormScript = crud_settings('site.partner_form');

        if($partnerFormScript){
            $partnerFormScript  = prepareFormScript($partnerFormScript , 'bform');
        }
    }


@endphp

@section('page_content')

    <section class="section about__section">
        <div class="container">

            <div class="row">
                <div class="col-xs-12 col-md-3 sidebar last-xs first-md">
                    <ul class="button__list">
                        <li><a href="{{ page_route('ourmission') }}" class="btn is__fullwidth has__icon"><img src="{{ url('/images/hands.png') }}" alt="">Наша миссия</a></li>
                        <li><a href="{{ page_route('contribution') }}" class="btn is__fullwidth has__icon"><img src="{{ url('/images/microphone.png') }}" alt="">Наш вклад</a></li>
                        <li><a href="{{ page_route('team') }}" class="btn is__fullwidth has__icon"><img src="{{ url('/images/team.png') }}" alt="">Команда</a></li>
                        <li><a href="{{ page_route('initiatives') }}" class="btn is__fullwidth has__icon"><img src="{{ url('/images/initiatives.png') }}" alt="">Инициативы</a></li>
                        <li><a href="{{ page_route('partner_packages') }}" class="btn is__fullwidth has__icon"><img src="{{ url('/images/partners.png') }}" alt="">Партнерские пакеты</a></li>

                    </ul>
                    <ul class="button__list">
                        {{--<li><a href="javascript:;" data-modalclass=".partner__form" class="btn is__fullwidth is__red is__rounded is__bold show-modal">Стать партнером</a></li>--}}
                        {{--<li><a href="javascript:;" data-modalclass=".speaker__form" class="btn is__fullwidth is__blue is__rounded is__bold show-modal">Стать спикером</a></li>--}}
                        <li><a href="{{ page_route('become_partner') }}" class="btn is__fullwidth is__red is__rounded is__bold">Стать партнером</a></li>
                        <li><a href="{{ page_route('become_speaker') }}" class="btn is__fullwidth is__blue is__rounded is__bold">Стать спикером</a></li>
                    </ul>
                </div>
                <div class="col-xs-12 col-md-9 content mb-30-xs mb-0-md">
                    <div class="block__header">
                        <p class="title">{{ $page->title }}</p>
                    </div>

                    <div class="body base__content table__wo_border">
                        {!! $page->body  !!}
                    </div>

                    @if(($page->code == 'team'))
                        <div class="row">
                        @foreach(data_team_members() as $item)
                            <div class="col-xs-12 col-md-6 row mb-25-xs pad-10-xs">
                                <div class="col-xs-12 col-md-4 pos-relative-xs pr-10-md center-xs row mt-20-xs mt-0-md middle-xs hidden-xs flex-md">
                                    <img src="{{ url($item->image) }}" alt="{{ $item->name }}" class="img-responsive pos-absolute-xs" style="top: 0">
                                </div>

                                <div class="col-xs-12 col-md-8 pl-10-md">
                                    <div class="col-xs-12">
                                        <p class="pt-10-xs pb-10-xs fw-700-xs fs-16-xs color-black">{{ mb_strtoupper( $item->name ) }}</p>
                                    </div>

                                    <div class="col-xs-12 col-md-12 ">
                                        <div class="row between-xs mb-10-xs">
                                            <p class="fw-300-xs fs-12-xs">{{ mb_strtoupper($item->position) }}</p>
                                        </div>
                                        <div class="ta-justify-xs ta-left-md fs-12-xs clampMe"><img src="{{ url($item->image) }}" alt="{{ $item->name }}" class="hidden-md fl-left-xs w-30-xs mr-10-xs">{!! $item->info !!}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    @endif

                    @if(($page->code == 'initiatives'))
                    @foreach ($posts->chunk(2) as $chunk)
                        <div class="block">
                        <div class="row block__content pad-5-xs pad-0-md">
                            @foreach ($chunk as $item)
                                <div class="col-xs-12 col-md-6 block__content_column mb-10-xs mb-0-md pad-5-xs">
                                    <div class="item row col card h-100-xs">
                                        <div class="image__wrapper h-250px-xs pos-relative-xs overflow-h">
                                            <img src="{{ url($item->image) }}" alt="{{ $item->title }}" class="img-by-h-xs">
                                        </div>
                                        <p class="title col-xs">{{$item->title}}</p>
                                        <p class="text col-xs">{{$item->excerpt}}</p>
                                        <div class="row card__footer between-xs">
                                            <p class="date">{{ $item->created }}</p>
                                            <p class="views">{{ $item->views }}</p>
                                        </div>

                                        <a href="{{ $item->url ? url($item->url) : 'javascript:;' }}" title="{{$item->title}}" class="fill"></a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        </div>
                    @endforeach
                    @endif

                    @if(($page->code == 'become_speaker') || ($page->code == 'become_partner'))
                        <div id="bform"></div>
                    @endif
                    @if( ($page->code == 'about') && !empty(crud_settings('site.about_video')) )
                        <div class="section video__wrapper">
                            {{--preload="auto"--}}
                            <video id="my_video_1" class="video-container video-js vjs-default-skin" controls preload="none">
                                <source src="{{ crud_settings('site.about_video') }}" type='video/mp4'>
                            </video>
                        </div>
                    @endif
                </div>

            </div>

        </div>
    </section>


    <div class="speaker__form modal">
        <div><a href="javascript:;" data-modalclass=".speaker__form" class="btn is__margined close-modal" >Закрыть</a></div>
    </div>

    <div class="partner__form modal">
        <div><a href="javascript:;" data-modalclass=".partner__form" class="btn is__margined close-modal">Закрыть</a></div>
    </div>
@endsection

@section('scripts')
    @parent

    @if(($page->code == 'become_partner') && $partnerFormScript)
        {!! $partnerFormScript !!}
    @endif

    @if(($page->code == 'become_speaker') && $speakerFormScript)
        {!! $speakerFormScript !!}
    @endif

@endsection