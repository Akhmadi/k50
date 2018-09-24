
<form action="#" enctype="multipart/form-data" method="post" class="form_event">
	<div class="form__field">
   <!-- <input type="tel" name="phone" placeholder="Телефон" pattern="\d{1}\s[\(]\d{3}[\)]\s\d{3}[\ ]\d{2}[\ ]\d{2}" minlength="17" maxlength="17" /> -->
		<input type="tel" name="phone" placeholder="8 (777) 123 45 67" minlength="17" maxlength="17" v-mask="'# (###) ### ## ##'" masked="true" />
		<span class="form__error">Номер телефона в формате 8 (123) 456 78 90</span>
	</div>
	<div class="form__field">
		<input type="text" name="lastName" placeholder="Фамилия*" required />
	</div>
	<div class="form__field">
		<input type="text" name="firstName" placeholder="Имя*" required />
	</div>
	<div class="form__field">
		<input type="email" name="email" placeholder="E-Mail" />
		<span class="form__error">E-Mail*</span>
	</div>
	<div class="form__field">
		<input type="text" name="company" placeholder="Название компании" />
		<span class="form__error">Название компании*</span>
	</div>
	<div class="form__field">
		<input type="text" name="position" placeholder="Должность" />
		<span class="form__error">Должность*</span>
	</div>
	<button type="submit">Отправить</button>
</form>
