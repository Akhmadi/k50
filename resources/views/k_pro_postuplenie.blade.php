@extends('layouts.page')

@php
    $guest = \Illuminate\Support\Facades\Auth::guest();
    $kpro = null;
    $kproOpened = false;

    if ($guest){

        if ($kpro = \App\Post::kpro()->where('status', \App\Post::POST_STATUS_ENABLED)->first())
            $kproOpened = $kpro->kproRegisterOpened;

    }
@endphp

@section('page_content')

    <div class="section kpro__section is__paddingless {{ !$guest ? 'logged_in' : '' }}">
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
                        <div>
                            <a href="{{ \App\PagesService::pageRoute('kpro_login') }}"
                            class="btn is__red width_240px is__rounded" >Войти</a>
                        </div>
                        @if($kproOpened)
                        <div>
                            <a href="{{ \App\PagesService::pageRoute('kpro_register') }}"
                            class="btn is__red width_240px is__rounded ml-30-md">Подать заявку</a>
                        </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        

        <div class="container">
            <div class="block_content">
                <div class="base__content margined__bottom pad-5-xs pad-0-md">
                    {!! $page->body !!}
                </div>
            </div>
        </div>
    </div>


@endsection

