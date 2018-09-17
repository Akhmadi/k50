@php
    $messages = session()->pull('messages',[]);
@endphp

<!doctype html >
<html lang="{{ app()->getLocale() }}" prefix="og: http://ogp.me/ns#">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-29153373-6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-29153373-6');
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('og')
    <title>@yield('page_title'){{ crud_settings('site.title') }}</title>
    @yield('styles')
    <link href="{{ url(asset('css/vendor/swiper/idangerous.swiper.css')) }}" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="/images/favicon.ico">
</head>
<body>
    <div id="app" class="page__wrapper">
        <div class="page__gap">
          <div class="container center-xs between-md">
            <div class="bar left">
                <p class="title fs-10-xs fs-14-md">{{ crud_settings('site.title') }}</p>
            </div>
            <div class="bar right">
                <ul class="socials">
                    <li class="item"><a href="{{ crud_settings('site.fb_url') }}"><i class="icon icon-facebook"></i></a></li>
                    <li class="item"><a href="{{ crud_settings('site.tw_url') }}"><i class="icon icon-twitter"></i></a></li>
                </ul>
            </div>
          </div>
        </div>

        <div class="page__content" >
            <header class="fixed-menu">
                <div class="container pad-5-xs pad-0-md">
                    <div class="toolbar left__toolbar">
                        <a href="{{ url('/') }}">
                            <img src="{{ crud_image(crud_settings('site.logo')) }}" alt="{{ crud_settings('site.title') }}" class="logo">
                        </a>
                    </div>
                    <div class="toolbar right__toolbar">
                      <div class="menu-wrapper pad-10-xs pad-0-md" :class="{opened: menuWrapper.isVisible}">
                          <div class="hidden-md ta-center-xs">
                              <a href="javascript:;"><i class="icon icon-cancel color-black" @click.stop.prevent="toggleMenuWrapper"></i></a>
                          </div>
                          {!! crud_menu('main') !!}
                      </div>
                      <a href="/search" class="search_btn"><i @click.stop.prevent="toggleSearchPanel" class="icon icon-search"></i></a>
                      <a href="javascript:;" class="hidden-md"><i class="icon icon-menu" @click.stop.prevent="toggleMenuWrapper"></i></a>
                    </div>
                </div>
            </header>
            <div class="" style="max-width: 1440px; margin: 0 auto">
                @yield('page_content')
            </div>
        </div>

        <div class="fixed_up_button is__active">
          <div class="fixed_up_button_inner">
            <i class="icon icon-up-open"></i>
          </div>
        </div>
        <footer>
            <div class="container pad-5-xs pad-0-md">
                <div class="row  between-xs middle-xs">
                  <div class="row col-xs-12 col-md-10">
                    <div class="logo__wrapper hidden-xs block-md">
                      <img src="{{ url('/images/logo_white.png') }}" alt="{{ crud_settings('site.title') }}">
                    </div>
                    <p class="description col-xs-12 col-md-10 ta-justify-xs ta-left-md">Kazakhstan Growth Forum стал конструктивной и профессиональной площадкой регулярного диспута, анализа и поиска решения стратегических проблем экономического развития Казахстана и отечественного бизнеса.</p>
                  </div>

                  <ul class="socials col-xs-12 col-md-2 row center-xs end-md">
                      <li class="item"><a href="{{ crud_settings('site.fb_url') }}"><i class="icon icon-facebook"></i></a></li>
                      <li class="item"><a href="{{ crud_settings('site.tw_url') }}"><i class="icon icon-twitter"></i></a></li>
                  </ul>
                </div>

                <div class="row between-xs bottom-xs">

                    <div class="hidden-xs block-md">
                        {!! crud_menu('main')  !!}
                    </div>

                    <div class="col-xs-12 col-md subscribe">
                        <div class="form__wrapper">
                            <form action="/" method="post">
                                {{ csrf_field() }}
                                <label for="email">Подписывайтесь на рассылку</label>
                                <div class="row end-xs">
                                  <input name="email" type="email" required placeholder="Email" v-model="subscribeEmail">
                                  <span @click="subscribe" class="send_button js-send-form row center-xs middle-xs"><i class="icon icon-mail"></i></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row middle-xs center-xs">
                    <p class="copyright">© 2018 | Kazakhstan Growth Forum</p>
                </div>
            </div>
        </footer>
        <div :class="{'is__active' : search.isPanelVisible }" class="search__panel">
            <div class="search__header row center-xs col-xs">
                <div class="col-xs-12 ta-left-xs pad-10-md pad-5-xs">
                    <a href="javascript:;" @click.stop.prevent="toggleSearchPanel" class="close-button"><i class="pos-relative-xs icon icon-cancel "></i></a>
                </div>

                <input type="text" v-model="search.value"
                       placeholder="введите текст для поиска"
                       @input.stop.prevent="searchValueChanged" class="form__control col-xs-12 col-md-6">
            </div>
            <div class="search__result">
                <div class="container">
                    <div v-for="group in searchGroups" class="search__group">
                        <p class="title">@{{ group }}</p>
                        <div v-for="item in searchItemsByGroup(group)" class="one__by__row__image__left">
                            <div class="image__wrapper">
                                <img :src="item.image" :alt="item.title">
                            </div>
                            <div class="info">
                                <a :href="item.url">
                                    <p class="title">@{{ item.title }}</p>
                                    <p class="date">@{{ item.created }}</p>
                                    <p class="excerpt">@{{ item.excerpt }}</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-show="messages.length" class="messages">
            <transition-group name="list" tag="p">
                <div :key="msg.id" v-for="msg in messages" class="message">
                    <p class="text">@{{ msg.text }}</p>
                    <i @click.stop.prevent="deleteMessage(msg)" class="icon icon-cancel"></i>
                </div>
            </transition-group>
        </div>
    </div>


    <script src="{{ url(asset('js/vendor/swiper/idangerous.swiper.min.js')) }}"></script>
    <script src="{{ url(asset('js/vendor/swiper/idangerous.swiper.scrollbar.js')) }}"></script>
    <script>
        baseUrl = '{{ url(env('APP_URL')) }}';
    </script>
    <script>
        var messages = {!! count($messages) ? json_encode($messages) : '[]' !!};
    </script>

    @yield('scripts')

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css" lazyload>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&amp;subset=cyrillic" rel="stylesheet" lazyload>
</body>
</html>
