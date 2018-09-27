<div class="col-xs-12">
	<form enctype="multipart/form-data" method="post" action="{{ url( route('forms.sobytiya.register')) }}" class="form_reg_event ">
	{{ csrf_field() }}
		<div class="header__container">
			<h2 class="header color_orange fs-16-xs mar-10-xs">РЕГИСТРАЦИЯ НА {{ mb_strtoupper($post->title) }}</h2>
		</div>
		
		<div class="form__body">
			<fieldset >				
				<div class="form__field row between-xs middle-xs mb-15-xs">
					<div class="col-xs-12 col-md-8 center-xs end-md  pad-5-xs pad-0-md">
						<the-mask class="maskPhone" name='phone' mask="# (###) ### ## ##" id="phone" v-model="userSobytiyaRegister.phone" placeholder="8 (XXX) XXX XX XX" required/>
					</div>
					<div class="col-xs-6 col-md-4 pad-5-xs pad-0-md">
						<p class="btn is__margined is__red findPhone" @click.stop.prevent="searchByPhone()">Найти Меня</p>
					</div>
				</div>
				
				<div class='row' v-show="userSobytiyaFound.isVisible">
					<div class="form__field col-xs-12 mb-15-xs">
						<label for="lastName" class="form__label label">Фамилия</label>
						<input type="text" v-model="userSobytiyaRegister.last_name" name='lastName' id="lastName" placeholder="ФАМИЛИЯ" required />
					</div>
				</div>
				<div class='row' v-show="userSobytiyaFound.isVisible">
					<div class="form__field col-xs-12 mb-15-xs">
						<label for="firstName" class="form__label label">Имя</label>
						<input type="text" v-model="userSobytiyaRegister.first_name" name='firstName' id="firstName" placeholder="ИМЯ" required />
					</div>
				</div>
				<div class='row' v-show="userSobytiyaFound.isVisible">
					<div class="form__field col-xs-12 mb-15-xs">
						<label for="email" class="form__label label">E-Mail</label>		
						<input type="email" v-model="userSobytiyaRegister.email" name='email' id="email" placeholder="E-MAIL@E-MAIL.KZ" required />
					</div>
				</div>
				<div class='row' v-show="userSobytiyaFound.isVisible">
					<div class="form__field col-xs-12 mb-15-xs">
						<label for="company" class="form__label label">Название компании</label>
						<input type="text" v-model="userSobytiyaRegister.company" name='company' id="company" placeholder="НАЗВАНИЕ КОМПАНИИ" required />
					</div>
				</div>
				<div class='row' v-show="userSobytiyaFound.isVisible">
					<div class="form__field col-xs-12 mb-15-xs">
						<label for="position" class="form__label label">Должность</label>
						<input type="text" v-model="userSobytiyaRegister.position" name='position' id="position" placeholder="ДОЛЖНОСТЬ" required />
					</div>
				</div>
				<div class="row" v-show="userSobytiyaFound.isVisible">
					<div class="form__field field_packages col-xs-12 mb-15-xs pt-15-xs">
						<label for="packages" class="form__label label">Пакет участника</label>
						<select name="packages" id="packages" placeholder="ПАКЕТ">
						@foreach($post->postPackages->sortBy('order') as $postPackage)
							<option id="{{ $postPackage->id }}" value="{{ $postPackage->desc }}" >Пакет "{{ $postPackage->title }}" стоимостью {{ $postPackage->amount }}</option>
						@endforeach
						</select> 
						<div id="package_info" class="package__info mt-10-xs"></div>
					</div>
				</div>

				<input type="hidden" name='parentUrl' value="{{ url()->current() }}" required />
				<input type="hidden" name='eventId' value="{{ $post->id }}" required />
			</fieldset>
		</div>
		<fieldset class="fieldset__footer" v-show="userSobytiyaFound.isVisible">
			<div class="row center-xs control__group">
				<input id="btn_stdt_form" type="submit" class="btn is__red is__rounded margined__bottom margined__top col-xs-12 col-sm-4 col-md-3" value="Отправить анкету">
			</div>
		</fieldset>			
	</form>
	
</div>