<html>
<head>
    <title>Заявка подтверждена</title>
</head>
<body>
<h4>Здравствуйте, {{ $user->name }}.</h4>
<p>Вы подавали заявку на участие в программе к-про, заявка рассмотрена и подтверждена</p>
<p>Ваш пароль {{ $user->newPassword }}</p>
<p>Для входа в личный кабинет пройдите по <a href="{{ url(\App\PagesService::pageRoute('kpro_login')) }}">ссылке</a></p>

</body>
</html>