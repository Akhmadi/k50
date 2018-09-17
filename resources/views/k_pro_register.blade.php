@extends('layouts.page')

@php
    if (\Illuminate\Support\Facades\Auth::check())
           redirect_now(url(\App\PagesService::pageRoute('kpro')));

    $kpro = \App\Post::kpro()->where('status', \App\Post::POST_STATUS_ENABLED)->first();
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

        <div class="container">
            <div class="quote">
                @if($kpro)
                    <p class="quote__text">Регистрация на программу {{ $kpro ? $kpro->title : ''}}</p>
                @else
                    <p class="quote__text">Регистрация на программу закрыта</p>
                @endif
            </div>
            <form enctype="multipart/form-data" method="post" action="{{ url( route('forms.students.register')) }}" class="form" >
                {{ csrf_field() }}
                <div class="control__group {{ $errors->has('lastname') ? ' has-error' : '' }} row middle-md">
                    <span class="col-xs-12 col-md-3">Фамилия</span>
                    <input type="text" required name="lastname" value="{{ old('lastname') }}" class="form__control col-xs-12 col-md-4">
                    @if($errors->has('lastname'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif

                </div>
                <div class="control__group {{ $errors->has('firstname') ? ' has-error' : '' }} row middle-md">
                    <span class="col-xs-12 col-md-3">Имя</span>
                    <input type="text" required name="firstname" value="{{ old('firstname') }}" class="form__control col-xs-12 col-md-4">
                    @if($errors->has('firstname'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="control__group {{ $errors->has('patronymic') ? ' has-error' : '' }} row middle-md">
                    <span class="col-xs-12 col-md-3">Отчество</span>
                    <input type="text" name="patronymic" value="{{ old('patronymic') }}" class="form__control col-xs-12 col-md-4">
                </div>
                <div class="row middle-md control__group {{ $errors->has('b_day') || $errors->has('b_month') || $errors->has('b_year') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">День, месяц и год рождения</span>
                    <div class="row col-xs-12 col-md-4 between-xs">
                        <select required name="b_day" value="{{ old('b_day') }}" class="form__control col-xs" >
                            <option value="" ></option>
                            @foreach(range(1,31, 1) as $day)
                                <option value="{{ $day }}">{{ $day }}</option>
                            @endforeach
                        </select>

                        <select required name="b_month" value="{{ old('b_month') }}" class="form__control col-xs">
                            <option value="" ></option>
                            @foreach(range(1,12, 1) as $month)
                                <option value="{{ $month }}">{{ $month }}</option>
                            @endforeach
                        </select>

                        <select required name="b_year" value="{{ old('b_year') }}" class="form__control col-xs">
                            <option value="" ></option>
                            @foreach(range(Carbon\Carbon::now()->year - 50,Carbon\Carbon::now()->year, 1) as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if($errors->has('b_day') || $errors->has('b_month') || $errors->has('b_year'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group {{ $errors->has('address') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Адрес проживания/город</span>
                    <textarea class="form__control col-xs-12 col-md-4" cols="30" rows="10" required name="address">{{ old('address') }}</textarea>
                    @if($errors->has('address'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif

                </div>
                <div class="row middle-md control__group {{ $errors->has('phone_home') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Телефон (домашний)</span>
                    <input type="text" name="phone_home" value="{{ old('phone_home') }}" class="form__control col-xs-12 col-md-4">
                    @if($errors->has('phone_home'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group {{ $errors->has('phone_mobile') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Телефон (мобильный)</span>
                    <input type="text" name="phone_mobile" value="{{ old('phone_mobile') }}" class="form__control col-xs-12 col-md-4">
                    @if($errors->has('phone_mobile'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">E-mail</span>
                    <input type="email" name="email" value="{{ old('email') }}" class="form__control col-xs-12 col-md-4">
                    @if($errors->has('email'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group{{ $errors->has('f1') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Уровень знания английского языка</span>
                    <select  name="f1" value="{{ old('f1') }}" class="form__control col-xs-12 col-md-4">
                        <option value="intermediate">intermediate</option>
                        <option value="upper-intermediate">upper-intermediate</option>
                        <option value="advanced">advanced</option>
                    </select>
                    @if($errors->has('f1'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group{{ $errors->has('f2') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Наличие сертификатов по профессиональному обучению, повышению квалификации и пр.</span>
                    <textarea class="form__control col-xs-12 col-md-4" cols="30" rows="10"  name="f2">{{ old('f2') }}</textarea>
                    @if($errors->has('f2'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group{{ $errors->has('f3') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Ваше самое большое достижение? Какой опыт вы из этого получили?</span>
                    <textarea class="form__control col-xs-12 col-md-4" cols="30" rows="10"  name="f3">{{ old('f3') }}</textarea>
                    @if($errors->has('f3'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group{{ $errors->has('f4') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Ваша самая большая неудача? Какой опыт вы из этого получили?</span>
                    <textarea class="form__control col-xs-12 col-md-4" cols="30" rows="10"  name="f4">{{ old('f4') }}</textarea>
                    @if($errors->has('f4'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group{{ $errors->has('f5') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Какие навыки хотите развить в себе?</span>
                    <textarea class="form__control col-xs-12 col-md-4" cols="30" rows="10"  name="f5">{{ old('f5') }}</textarea>
                    @if($errors->has('f5'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group{{ $errors->has('f6') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Принимали ли Вы участие в социальных проектах в качестве волонтера?</span>
                    <textarea class="form__control col-xs-12 col-md-4" cols="30" rows="10"  name="f6">{{ old('f6') }}</textarea>
                    @if($errors->has('f6'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group{{ $errors->has('f7') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Вы принимали активное участие в общественной жизни школы, ВУЗа?</span>
                    <textarea class="form__control col-xs-12 col-md-4" cols="30" rows="10"  name="f7">{{ old('f7') }}</textarea>
                    @if($errors->has('f7'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group{{ $errors->has('f8') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">Состояли ли Вы в молодежных организациях или же был ли у Вас статус «Президента» школы (или ВУЗа)?</span>
                    <textarea class="form__control col-xs-12 col-md-4" cols="30" rows="10"  name="f8">{{ old('f8') }}</textarea>
                    @if($errors->has('f8'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group{{ $errors->has('f9') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">У Вас есть достижения в спорте, творчестве и других сферах жизни?</span>
                    <textarea class="form__control col-xs-12 col-md-4" cols="30" rows="10"  name="f9">{{ old('f9') }}</textarea>
                    @if($errors->has('f9'))
                        <span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>
                    @endif
                </div>
                <div class="row middle-md control__group{{ $errors->has('f10') ? ' has-error' : '' }}">
                    <span class="col-xs-12 col-md-3">ВУЗ/Место работы</span>
                    <textarea class="form__control col-xs-12 col-md-4" cols="30" rows="10"  name="f10">{{ old('f10') }}</textarea>
                    {{--@if($errors->has('f10'))--}}
                        {{--<span class="error col-xs-12 col-md-3">Поле необходимо заполнить</span>--}}
                    {{--@endif--}}
                </div>

                <div class="row middle-md control__group">
                    <span class="col-xs-12 col-md-3">Файл №1</span>
                    <input type="file" name="file1" class="form__control col-xs-12 col-md-4" required>
                </div>
                <div class="row middle-md control__group">
                    <span class="col-xs-12 col-md-3">Файл №2</span>
                    <input type="file" name="file2" class="form__control col-xs-12 col-md-4" required>
                </div>
                <div class="row middle-md control__group">
                    <span class="col-xs-12 col-md-3">Файл №3</span>
                    <input type="file" name="file3" class="form__control col-xs-12 col-md-4">
                </div>
                <div class="row middle-md control__group">
                    <span class="col-xs-12 col-md-3">Файл №4</span>
                    <input type="file" name="file4" class="form__control col-xs-12 col-md-4">
                </div>
                <div class="row center-xs control__group">
                    <input type="submit" class="btn is__red is__rounded margined__bottom margined__top col-xs-12 col-sm-4 col-md-3" value="Отправить анкету">
                </div>

                <div class="info pad-5-xs pad-0-md">
                    <h5 class="color_orange font_semibold font_s16">Правила обучения</h5>
                    <p class="margined__bottom font_s16">Это правила, которым должны следовать участники. Если участник нарушает эти правила, ему придется покинуть обучение (по решению организаторов). Обязательно участие полностью во всех практиках семинара, от начала до конца. Необходимо выполнять задания, участвовать в практиках проводимых на обучении. Необходимо относиться с уважением и уважать личные границы других участников.</p>

                    <h5 class="color_orange font_semibold font_s16">Удостоверение:</h5>
                    <div class="margined__bottom font_s16">
                        <ul class="margined__bottom">
                            <li>Я удостоверяю правильность данных предоставленных в анкете, касающихся моих персональных данных.</li>
                            <li>Я обязуюсь выполнять перечисленные выше правила.</li>
                            <li>Если я почувствую себя плохо и/или заболею и/или произойдет изменение в состоянии моего здоровья, я немедленно сообщу об этом организаторам.</li>
                        </ul>

                        <p>Анкета, направленная на адрес организатора, подтверждает ознакомление с правилами обучения и подтверждает согласие на обработку персональных данных, в соответствии с законом РК о персональных данных.</p>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection

