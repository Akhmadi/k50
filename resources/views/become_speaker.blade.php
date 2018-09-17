@extends('layouts.page')

@php
    $speakers = \App\Person::forumSpeakers()->take(20)->get();
    $partners = \App\Person::forumPartners()->take(20)->get();


    $speakerFormScript = crud_settings('site.speaker_form');

    if($speakerFormScript){
        $speakerFormScript  = prepareFormScript($speakerFormScript , 'bform_speaker');
    }
@endphp

@section('page_content')

    <section class="section about__section">
        <div class="container">

            <div class="row">
                <div class="col-xs-3 sidebar">
                    <ul class="button__list">
                        <li><a href="{{ page_route('ourmission') }}" class="btn is__fullwidth has__icon"><img src="{{ url('/images/hands.png') }}" alt="">Наша миссия</a></li>
                        <li><a href="{{ page_route('contribution') }}" class="btn is__fullwidth has__icon"><img src="{{ url('/images/microphone.png') }}" alt="">Наш вклад</a></li>
                        <li><a href="{{ page_route('team') }}" class="btn is__fullwidth has__icon"><img src="{{ url('/images/team.png') }}" alt="">Команда</a></li>
                    </ul>
                    <ul class="button__list">
                        <li><a href="javascript:;" data-modalclass=".partner__form" class="btn is__fullwidth is__red is__rounded is__bold show-modal">Стать партнером</a></li>
                        <li><a href="javascript:;" data-modalclass=".speaker__form" class="btn is__fullwidth is__blue is__rounded is__bold show-modal">Стать спикером</a></li>
                    </ul>
                </div>
                <div class="col-xs-9 content">
                    <div class="block__header">
                        <p class="title">{{ $page->title }}</p>
                    </div>
                    <div id="bform_speaker" class="bform"></div>

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
        <div id="bform_partner" class="bform"></div>
    </div>
@endsection

@section('scripts')
    @parent

    @if($speakerFormScript)
        {!! $speakerFormScript !!}
    @endif

@endsection