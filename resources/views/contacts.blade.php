@extends('layouts.page')

@php
    $coords = explode(',', crud_settings('site.map_coords'));

    if (count($coords) == 2){
        $lat = $coords[0];
        $lng = $coords[1];
    }

@endphp

@section('page_content')
    <div class="contacts__section">

        <div class="container">
            <div class="row">
                <div class="col-xs-12 section__title">
                    <div class="block__header mar-5-xs mar-0-md">
                        <div class="title">Контакты</div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 contacts__form">

                    <div class="mar-5-xs mar-0-md">
                        <h4 class="h4">Наш офис</h4>
                        <p>{{ crud_settings('site.address') }}</p>
                        <p>Телефон: {{ crud_settings('site.phone') }}</p>
                        <p>E-mail: {{ crud_settings('site.email') }}</p>
                    </div>

                    <div class="form js-feedback-form mar-5-xs mar-0-md mb-20-xs mb-0-md">
                        <h4 class="h4">Форма обратной связи</h4>
                        <input v-model="feedbackForm.name" type="text" name="name" placeholder="ФИО" class="form__control is__fullwidth">
                        <input v-model="feedbackForm.email" type="text" name="email" placeholder="E-mail" class="form__control is__fullwidth">
                        <input v-model="feedbackForm.subject" type="text" name="subject" placeholder="Тема сообщения" class="form__control is__fullwidth">
                        <textarea v-model="feedbackForm.text" name="text" cols="30" rows="10" placeholder="Текст сообщения" class="form__control is__fullwidth"></textarea>
                        <a @click="feedback" href="javascript:;" class="btn is__red is__rounded is__fullwidth">Отправить</a>
                    </div>
                </div>
                <div class="col-xs-12 col-md-8 contacts__map">
                    <div id="map" class="map"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        function initMap() {
            var uluru = {lat: {{ $lat }}, lng: {{ $lng }} };
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 14,
                center: uluru
            });
            var marker = new google.maps.Marker({
                position: uluru,
                map: map
            });
        }
    </script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAA6eTSNtTGtTOnvOIah6c4Eimcmqd9Znc&callback=initMap">
    </script>
@endsection