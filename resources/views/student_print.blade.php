@php

    if ($studentId = $params['id']['value']){

        $user = \App\User::where('id', $studentId)->where('type', 'student')->first();

    }
@endphp

<!doctype html >
<html lang="{{ app()->getLocale() }}" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page_title'){{ crud_settings('site.title') }}</title>
    <link rel="shortcut icon" href="/images/favicon.ico">
</head>
<body>
    @if ($user)
        <h2>Анкета студента</h2>
        <h3>ФИО: {{ $user->name }} </h3>
        <h4>E-mail: {{ $user->email }} </h4>
        <p><b>Дата рождения:</b></p>
        <p>{{ $user->getMetaValue('birth_date') }}</p>
        <p><b>Адрес:</b></p>
        <p>{{ $user->getMetaValue('address') }}</p>
        <p><b>Тел.домашний:</b></p>
        <p>{{ $user->getMetaValue('phone_home') }}</p>
        <p><b>Тел.мобильный:</b></p>
        <p>{{ $user->getMetaValue('phone_mobile') }}</p>
        <p><b>Место работы/учебы</b></p>
        <p>{{ $user->getMetaValue('f10') }}</p>
        <p><b>Должность/Специальность</b></p>
        <p>{{ $user->getMetaValue('f10') }}</p>                
        <p><b>Уровень знания английского языка:</b></p>
        <p>{{ $user->getMetaValue('f1') }}</p>
        <p><b>Наличие сертификатов по профессиональному обучению, повышению квалификации и пр.</b></p>
        <p>{{ $user->getMetaValue('f2') }}</p>
        <p><b>Ваше самое большое достижение? Какой опыт вы из этого получили?</b></p>
        <p>{{ $user->getMetaValue('f3') }}</p>
        <p><b>Ваша самая большая неудача? Какой опыт вы из этого получили?</b></p>
        <p>{{ $user->getMetaValue('f4') }}</p>
        <p><b>Какие навыки хотите развить в себе?</b></p>
        <p>{{ $user->getMetaValue('f5') }}</p>
        <p><b>Принимали ли Вы участие в социальных проектах в качестве волонтера?</b></p>
        <p>{{ $user->getMetaValue('f6') }}</p>
        <p><b>Вы принимали активное участие в общественной жизни школы, ВУЗа?</b></p>
        <p>{{ $user->getMetaValue('f7') }}</p>
        <p><b>Состояли ли Вы в молодежных организациях или же был ли у Вас статус «Президента» школы (или ВУЗа)?</b></p>
        <p>{{ $user->getMetaValue('f8') }}</p>
        <p><b>У Вас есть достижения в спорте, творчестве и других сферах жизни?</b></p>
        <p>{{ $user->getMetaValue('f9') }}</p>
    @else
        <p>Анкета не найдена</p>
    @endif
</body>