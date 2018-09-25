<div class="form_event" id="appSearch">
	<div class="form__field row">
		<div class="col-xs-8">
			<the-mask class="maskPhone" mask="# (###) ### ## ##" v-model="userSobytiyaRegister.phone"/>
		</div>
		<div class="col-xs-4">
			<p class="btn is__red is__margined findPhone" @click.stop.prevent="searchByPhone()">Найти Меня</p>
		</div>
	</div>
	<div class="form__field">
		<input type="text" v-model="userSobytiyaRegister.last_name" v-show="userSobytiyaFound" name="lastName" placeholder="Фамилия*" required />
	</div>
	<div class="form__field">
		<input type="text" v-model="userSobytiyaRegister.first_name" v-show="userSobytiyaFound" name="firstName" placeholder="Имя*" required />
	</div>
	<div class="form__field">
		<input type="email" v-model="userSobytiyaRegister.email" v-show="userSobytiyaFound" name="email" placeholder="E-Mail" />
	</div>
	<div class="form__field">
		<input type="text" v-model="userSobytiyaRegister.company" v-show="userSobytiyaFound" name="company" placeholder="Название компании" />
	</div>
	<div class="form__field">
		<input type="text" v-model="userSobytiyaRegister.position" v-show="userSobytiyaFound" name="position" placeholder="Должность" />
	</div>
</div>
