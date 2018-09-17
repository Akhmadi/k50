@extends('layouts.page')

@php
    if (\Illuminate\Support\Facades\Auth::check())
        redirect_now(url(\App\PagesService::pageRoute('kpro')));
@endphp

@section('page_content')

    <div class="section kpro__section is__paddingless">
        <div class="image__wrapper title__image">
            <div class="container">
                <div class="row col-xs-12 between-md mb-20-xs mb-80-md">
                    <div class="col-xs-12 col-md center-xs start-md">
                        <img src="{{ url( crud_image(crud_settings('site.kpro_logo')), false) }}" alt="" class="kpro__logo">
                    </div>
                    <div class="col-xs-12 col-md row center-xs end-md mt-20-xs mt-0-md">
                        <div class="kpro_steps row between-xs pl-5-xs pl-0-md pr-5-xs pr-0-md">
                            <span class="kpro_steps__item"><a class="link" href="{{ page_route('k_pro_postuplenie') }}">поступление</a></span>
                            <span class="kpro_steps__item"><a class="link" href="{{ page_route('studentlife') }}">student life</a></span>
                            <span class="kpro_steps__item">обучение</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container text-center">
            <div class="row center-sm">
                <h4 class="h4 margined__bottom margined__top col-xs-12 ta-center-xs">Авторизация студента</h4>
                <form class="col-xs-12 col-sm-6 margined__bottom" novalidate method="post" action="{{ url( route('forms.students.login')) }}">
                    {{ csrf_field() }}
                    <div class="control__group margined__bottom row">
                        <input type="email" name="email" required class="form__control col-xs-12"
                               placeholder="E-mail">
                    </div>
                    <div class="control__group margined__bottom row">
                        <input type="password" name="password" required class="form__control col-xs-12" placeholder="Пароль">
                    </div>
                    <div class="row center-sm pad-5-xs pad-0-md">
                        <input type="submit" class="btn is__red is__rounded padded__left padded__right col-xs-12 col-sm-6" value="Вход">
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

