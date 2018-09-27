<html>
    <head></head>
    <body>

        <div style="display: table; width: 100%; text-align: center; height: 40px; background: #ff0a0a; color: #fff; font-family: 'Open Sans', Arial, sans-serif; font-size: 14px; font-weight: bold;">
            <div style="display: table-cell; vertical-align: middle;"><h2 style="margin: auto">Регистрация на {{ $eventName }}</h2></div>
        </div>
         
        <div>
            <div style="width: 80%; padding: 0 10%; text-align: center;">
				<table>
					<tr>
						<td><b>Фамилия</b></td>
						<td>{{ $eventUser['last_name'] }}</td>
					</tr>
					<tr>
						<td><b>Имя</b></td>
						<td>{{ $eventUser['first_name'] }}</td>
					</tr>
					<tr>
						<td><b>Телефон</b></td>
						<td>{{ $eventUser['phone'] }}</td>
					</tr>
					<tr>
						<td><b>E-Mail</b></td>
						<td>{{ $eventUser['email'] }}</td>
					</tr>
					<tr>
						<td><b>Название компании</b></td>
						<td>{{ $eventUser['company'] }}</td>
					</tr>
					<tr>
						<td><b>Должность</b></td>
						<td>{{ $eventUser['position'] }}</td>
					</tr>
					<tr>
						<td><b>Выбранный пакет</b></td>
					</tr>
				</table>
            </div>
        </div>
     
    </body>
</html>