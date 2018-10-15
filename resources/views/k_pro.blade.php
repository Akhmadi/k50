@extends('layouts.page')

@php
    $guest = \Illuminate\Support\Facades\Auth::guest();

    $kpro = null;
    $kproOpened = false;
    $noAvail = false;

    if ($guest){

        if ($kpro = \App\Post::kpro()->where('status', \App\Post::POST_STATUS_ENABLED)->first())
            $kproOpened = $kpro->kproRegisterOpened;

    } else {
        $user = \Illuminate\Support\Facades\Auth::user();



        $qb = \App\Post::kpro();

        $kpros = $qb->whereHas('students', function($q) use ($user){
            return $q->where('posts_users.user_id','=',$user->id)->where('posts_users.status','=','enabled');
        })->get();

        if ($kpros->count()){

            debug($params['slug']['value']);

            debug(str_replace(\App\Post::SLUG_SUFFIX, '', $params['slug']['value']));

            if ($params['slug']['value'])
                $kpro = $kpros
                    ->where('slug', str_replace(\App\Post::SLUG_SUFFIX, '', $params['slug']['value']))
                    ->first();
            else
                $kpro = $kpros->first();
        }
        else {
            $noAvail = true;
        }

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
                        <a href="{{ \App\PagesService::pageRoute('kpro_login') }}"
                           class="btn is__red width_240px is__rounded" >Войти</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="container">
            @if ($guest)
                <div class="quote">
                    <p class="quote__text">Период приема заявок с {{ $kpro && $kpro->kproStartDate ? getFormattedDate($kpro->kproStartDate , 'short') : '' }} по {{ $kpro && $kpro->kproEndDate ? getFormattedDate($kpro->kproEndDate , 'short') : '' }}</p>
                </div>
                <div class="block_content pad-5-xs pad-0-md">
                    <div class="base__content margined__bottom">
                        {!! $kpro ? $kpro->body : ($page->body ? $page->body : '')  !!}
                    </div>
                </div>
                <div class="quote">
                    <p class="quote__text quote__text_large">Внимание</p>
                    <p class="quote__text">Участники программы будут отбираться на конкурсной основе. Количество участников ограничено – {{ $kpro ? $kpro->kproMaxStudents : '0' }} человек.</p>
                </div>
            @elseif ($noAvail)
                <div class="quote">
                    <p class="quote__text">К сожалению, у Вас нет доступных программ K-Pro</p>
                </div>
                <div class="row col-xs-12 center-xs row  mb-20-xs mb-0-md">
                    <form action="{{ route('forms.students.logout') }}" method="post">
                        {{ csrf_field() }}
                        <div class="control__group row">
                            <input type="submit" class="col-xs-12 btn is__red is__rounded is__red_outlined" value="Выйти из личного кабинета">
                        </div>
                    </form>
                </div>
            @else
                @if($kpros->count() > 1)
                    <div class="ta-center-xs ta-left-md">
                        <p class="fs-18-xs fw-700-xs">Доступные программы k-pro</p>
                        <div class="row">
                            @foreach($kpros as $kproItem)
                                <div class="col-xs-12 pad-5-xs">
                                    <span>{{ $kproItem->id == $kpro->id ? 'x ' : '' }}</span> <a href="{{ $kproItem->url }}" class="link">{{ $kproItem->title }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="tabs row top-xs">
                    <div class="tab__header col-xs-12 col-md-4 row top-xs">
                        <span class="tab btn is__rounded is__active_red is__active col-xs-12 mb-30-md large has__icon" data-tab-id="1"><img src="{{ url('/images/info.png') }}" alt="">Программа</span>
                        <span class="tab btn is__rounded is__active_red col-xs-12 mb-30-md large has__icon" data-tab-id="4"><img src="{{ url('/images/files.png') }}" alt="">Раписание</span>
                        <span class="tab btn is__rounded is__active_red col-xs-12 mb-30-md large has__icon" data-tab-id="2"><img src="{{ url('/images/file.png') }}" alt="">Презентации</span>
                        <span class="tab btn is__rounded is__active_red col-xs-12 mb-30-md large has__icon" data-tab-id="3"><img src="{{ url('/images/microphone.png') }}" alt="">Спикеры</span>
                        <span class="tab btn is__rounded is__active_red col-xs-12 mb-30-md large has__icon" data-tab-id="5"><img src="{{ url('/images/clipboard.png') }}" alt="">Задания для студента</span>
                        <span class="tab btn is__rounded is__active_red col-xs-12 mb-30-md large has__icon" data-tab-id="7"><img src="{{ url('/images/rules.png') }}" alt="">Правила</span>
                        <span class="tab btn is__rounded is__active_red col-xs-12 has__icon" data-tab-id="6"><img src="{{ url('/images/social.png') }}" alt="">Личные данные</span>
                    </div>
                    <div class="tab__content  col-xs-12 col-md-8">
                        <div class="tab is__active" data-tab-id="1">
                            @if($kpro)
                            <div class="quote">
                                <p class="quote__text">Период приема заявок с {{ getFormattedDate($kpro->kproStartDate , 'short') }} по {{ getFormattedDate($kpro->kproEndDate , 'short') }}</p>
                            </div>
                            <div class="base__content body pl-5-xs pl-0-md pr-5-xs pr-0-md">
                                {!! $kpro ? $kpro->body : '' !!}
                            </div>
                            <div class="quote">
                                <p class="quote__text quote__text_large">Внимание</p>
                                <p class="quote__text">Участники программы будут отбираться на конкурсной основе. Количество участников ограничено – {{ $kpro->kproMaxStudents }} человек.</p>
                            </div>
                            @endif
                        </div>
                        <div class="tab" data-tab-id="2">
                            @if($kpro)
                                <div class="program__plan pl-5-xs pl-0-md pr-5-xs pr-0-md">
                                    <div class="plan__row">
                                        <div class="time">Дата</div>
                                        <div class="text">Название презентации</div>
                                        <div class="download">Скачать</div>
                                    </div>
                                    @foreach($kpro->presentations as $item)
                                        <div class="plan__row">
                                            <div class="time">{{ getFormattedDate($item->begin_at, 'short') }}</div>
                                            <div class="text">{{ $item->title }}</div>
                                            <div class="download text__center"><a href="{{ $item->url }}"><img src="{{ url('/images/file_2.png') }}" alt=""></a></div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="tab" data-tab-id="3">
                            @if($kpro)
                            <div class="speakers ">
                                @foreach($kpro->forumSpeakers->chunk(3) as $chunk)
                                    <div class="row">
                                    @foreach($chunk as $speaker)
                                    <div class="col-xs-12 col-md-4 padded small">
                                        <div class="speaker">
                                            <div class="image__wrapper">
                                                <img src="{{ url($speaker->image ? $speaker->image : '/') }}" alt="{{ $speaker->name }}">
                                                <div class="bio hidden-xs flex-md row col end-xs">
                                                    <p class="fs-12-xs pad-5-xs ta-justify-xs">{{ $speaker->info}}</p>
                                                    @if($speaker->press)
                                                        <div class="ta-center-xs presentation-button">
                                                            <a href="{{ url($speaker->press) }}" target="_blank" class="link">Скачать презентацию</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="info">
                                                <p>{{ $speaker->subject }}</p>
                                                <p>{{ $speaker->name }}</p>
                                                <div class="hidden-md">
                                                    <p class="fs-12-xs pad-5-xs ta-justify-xs">{{ $speaker->info}}</p>
                                                    @if($speaker->press)
                                                        <div class="ta-center-xs presentation-button">
                                                            <a href="{{ url($speaker->press) }}" target="_blank" class="link">Скачать презентацию</a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="tab" data-tab-id="4">
                            {{--<a href="{{ url($kpro->kproProgramUrl) }}" class="btn is__outlined">Скачать программу</a>--}}
                            @if($kpro)
                            <div class="program__plan">
                                <div class="plan__row">
                                    <div class="time">Время</div>
                                    <div class="text">План</div>
                                </div>
                                @foreach($kpro->timeLines as $timeLine)
                                    <div class="plan__row">
                                        <div class="time">{{ $timeLine->planned_time }}</div>
                                        <div class="text">{{ $timeLine->planned_part }}</div>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                        <div class="tab" data-tab-id="5">
                            {{--<div class="program__plan">--}}
                                {{--<div class="plan__row">--}}
                                    {{--<div class="time">Компания</div>--}}
                                    {{--<div class="column column_right-border column_title">Задание</div>--}}
                                    {{--<div class="time">Дата защиты</div>--}}
                                    {{--<div class="time">Время защиты</div>--}}
                                {{--</div>--}}
                                {{--@if($kpro)--}}
                                    {{--@foreach($kpro->tasks as $task)--}}
                                        {{--<div class="plan__row">--}}
                                            {{--<div class="time"><a href="{{ $task->company->url }}">{{ $task->company->name }}</a></div>--}}
                                            {{--<div class="column column_right-border"><a href="{{ $task->file }}" class="link">{{ $task->title }}</a></div>--}}
                                            {{--<div class="time"><span>{{ getFormattedDate($task->begin_at, 'short') }}</span></div>--}}
                                            {{--<div class="time"><span>{{ $task->start_time }} - {{ $task->end_time }}</span></div>--}}
                                        {{--</div>--}}
                                    {{--@endforeach--}}
                                {{--@endif--}}
                            {{--</div>--}}

                            <div class="row">
                                <div class="col-xs-12 row">
                                    <div class="bordered-gray col-xs-3 pad-5-xs pad-10-xs fw-700-xs fs-16-xs fs-18-md">Компания</div>
                                    <div class="bordered-gray col-xs-3 col-md-5 pad-5-xs pad-10-xs fw-700-xs fs-16-xs fs-18-md">Задание</div>
                                    <div class="bordered-gray col-xs-3 col-md-2 pad-5-xs pad-10-xs fw-700-xs fs-16-xs fs-18-md">Дата защиты</div>
                                    <div class="bordered-gray col-xs-3 col-md-2 pad-5-xs pad-10-xs fw-700-xs fs-16-xs fs-18-md">Время защиты</div>
                                </div>
                                @if($kpro)
                                    @foreach($kpro->tasks as $task)
                                        <div class="col-xs-12 row mt-10-xs mt-0-md">
                                            <div class="bordered-gray col-xs-12 col-md-3 pad-5-xs pad-10-xs fs-16-xs fs-18-md"><a href="{{ $task->company->url }}">{{ $task->company->name }}</a></div>
                                            <div class="bordered-gray col-xs-12 col-md-5 pad-5-xs pad-10-xs fs-16-xs fs-18-md"><a href="{{ $task->file }}" class="link">{{ $task->title }}</a></div>
                                            <div class="bordered-gray col-xs-6 col-md-2 pad-5-xs pad-10-xs fs-16-xs fs-18-md"><span>{{ getFormattedDate($task->begin_at, 'short') }}</span></div>
                                            <div class="bordered-gray col-xs-6 col-md-2 pad-5-xs pad-10-xs fs-16-xs fs-18-md"><span>{{ $task->start_time }} - {{ $task->end_time }}</span></div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                        </div>
                        <div class="tab" data-tab-id="7">
                            @if($kpro)
                            <div class="quote">
                                <p class="quote__text">Правила участия в программе К-Про</p>
                            </div>
                            <div class="base__content body pl-5-xs pl-0-md pr-5-xs pr-0-md">
                                {!! $kpro ? $kpro->excerpt : '' !!}
                            </div>
                            @endif
                        </div>                       
                        <div class="tab" data-tab-id="6">
                            <div class="quote text__center quote_paddingless">
                                <div class="quote__text quote__text_black">Для изменения контактных данных необходимо обратиться в офис компании</div>
                            </div>
                            <div>
                                <div class="control__group row middle-md">
                                    <span class="col-xs-12 col-md-3">Имя</span>
                                    <input class="form__control col-xs-12 col-md-6" type="text" name="firstname" required value="{{ $user->firstName }}">
                                </div>
                                <div class="control__group row middle-md">
                                    <span class="col-xs-12 col-md-3">Фамилия</span>
                                    <input class="form__control col-xs-12 col-md-6" type="text" name="lastname" required value="{{ $user->lastName }}">
                                </div>
                                <div class="control__group row middle-md">
                                    <span class="col-xs-12 col-md-3">Отчество</span>
                                    <input class="form__control col-xs-12 col-md-6" type="text" name="patronymic" required value="{{ $user->patronymic }}">
                                </div>
                                <div class="control__group row middle-md">
                                    <span class="col-xs-12 col-md-3">email</span>
                                    <input class="form__control col-xs-12 col-md-6" type="text" name="email" required value="{{ $user->email }}">
                                </div>
                                <div class="control__group row middle-md">
                                    <span class="col-xs-12 col-md-3">Телефон</span>
                                    <input class="form__control col-xs-12 col-md-6" type="text" name="phone" required value="{{ $user->phoneMobile }}">
                                </div>

                                <form action="{{ route('forms.students.password') }}" method="post" class="row between-md">
                                    {{ csrf_field() }}
                                    <div class="control__group col-xs-12 col-md-9 row middle-md">
                                        <span class="col-xs-12 col-md-4">Новый пароль</span>
                                        <input class="form__control col-xs-12 col-md-8" type="password" name="password" required>
                                    </div>
                                    <div class="col-xs-12 col-md control__group">
                                        <input type="submit" class="btn is__red is__rounded w-100-xs w-auto-md" value="Сменить пароль">
                                    </div>
                                </form>

                                <form action="{{ route('forms.students.logout') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="control__group row">
                                        <input type="submit" class="col-xs-12 col-md-6 btn is__red is__rounded is__red_outlined" value="Выйти из личного кабинета">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>


@endsection

