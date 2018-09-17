<h3>Поступила анкета от {{ $user['name'] }} ({{ $user['email'] }})</h3><br>

<a href="{{ url( page_route('studentprint', ['id' => $user->id ])) }}">Печать анкеты</a>

<p><b>ФИО</b></p>
<p>{{ $user['name'] }}</p><br>
<p><b>Дата рождения</b></p>
<p>{{ $user->getMetaValue('birth_date') }}</p><br>
<p><b>Адрес</b></p>
<p>{{ $user->getMetaValue('address') }}</p><br>
<p><b>Тел.домашний</b></p>
<p>{{ $user->getMetaValue('phone_home') }}</p><br>
<p><b>Тел.мобильный</b></p>
<p>{{ $user->getMetaValue('phone_mobile') }}</p><br>
<p><b>Уровень знания английского языка</b></p>
<p>{{ $user->getMetaValue('f1') }}</p><br>
<p><b>Наличие сертификатов по профессиональному обучению, повышению квалификации и пр.</b></p>
<p>{{ $user->getMetaValue('f2') }}</p><br>
<p><b>Ваше самое большое достижение? Какой опыт вы из этого получили?</b></p>
<p>{{ $user->getMetaValue('f3') }}</p><br>
<p><b>Ваша самая большая неудача? Какой опыт вы из этого получили?</b></p>
<p>{{ $user->getMetaValue('f4') }}</p><br>
<p><b>Какие навыки хотите развить в себе?</b></p>
<p>{{ $user->getMetaValue('f5') }}</p><br>
<p><b>Принимали ли Вы участие в социальных проектах в качестве волонтера?</b></p>
<p>{{ $user->getMetaValue('f6') }}</p><br>
<p><b>Вы принимали активное участие в общественной жизни школы, ВУЗа?</b></p>
<p>{{ $user->getMetaValue('f7') }}</p><br>
<p><b>Состояли ли Вы в молодежных организациях или же был ли у Вас статус «Президента» школы (или ВУЗа)?</b></p>
<p>{{ $user->getMetaValue('f8') }}</p><br>
<p><b>У Вас есть достижения в спорте, творчестве и других сферах жизни?</b></p>
<p>{{ $user->getMetaValue('f9') }}</p><br>
<p><b>ВУЗ/Место работы</b></p>
<p>{{ $user->getMetaValue('f10') }}</p><br>



