@extends('layouts.page')

@php
    $slides = cache()->get('cached.slides', []);

    $news = cache()->get('cached.news', []);

    $phrases = cache()->get('cached.phrases', []);

    $ratings = cache()->get('cached.ratings', []);

    $featurePosts = cache()->get('cached.featuredEvents', []);

    $products = \App\Post::partnerProducts()->onlyEnabled()->get();

@endphp

@section('page_content')
    {{-- <div class="section section_header"> --}}
        <div class="container">
            <div class="main__block">
                <div class="main__slider swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($slides as $slide)
                        <div class="swiper-slide slide">
                            <a href="{{ $slide->slug }}" >
                                <div class="pos-relative-xs overflow-h h-50-xs h-100-xs">
                                    <img src="{{ $slide->image ? url($slide->image) : '' }}" alt="{{ $slide->title }}" class="img-by-w-md img-by-h-xs">
                                </div>
                                <div class="excerpt">
                                    <p class="title">{{ $slide->title }}</p>
                                    <p class="text">{{ $slide->excerpt }}</p>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                    <div class="pagination row center-xs pad-10-xs"></div>

                    {{--<div class="slider-navigation row center-xs pad-10-xs">--}}
                        {{--@foreach(range(1, count($slides)) as $i)--}}
                            {{--<div data-slide-id="{{ $i }}" role="button" class="slider-navigation-point mr-10-xs"></div>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                </div>
                <div class="quotes ">
                    <div class="block__header">
                        <p class="title">Предстоящие события</p>
                    </div>
                    <div class="row">
                        @foreach( $featurePosts as $post)
                            <div class="col-xs-12 ">
                                <div class="pointed-list-item">
                                    <div class="point"></div>
                                    <div class="content row between-xs end-xs">
                                        <p class="date">{{ getFormattedDate($post->eventDate) }}</p>
                                        <p class="views">{{ $post->views }}</p>
                                        <p class="text col-xs-12">{{ $post->title }}</p>
                                    </div>
                                    <a href="{{ $post->url }}" title="{{$post->title}}" class="pointed-list-item__url"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="section pb-20-xs pb-60-md">
              <div class="row">
                <div class="col-xs-12 col-md-8">
                  <div class="block block__2_3">
                    <div class="block__header row between-xs bottom-xs ml-5-xs ml-0-md mr-5-xs mr-0-md">
                      <p class="title">новости</p>
                      <a href="{{ page_route('news') }}" class="forward_button">Все новости <i class="icon icon-right-open"></i></a>
                    </div>
                    <div class="row block__content ml-5-xs ml-0-md mr-5-xs mr-0-md">
                      @foreach( $news as $item)
                          <div class="item col-xs-12 col-md-6 row col">
                              <div class="h-auto-xs h-200px-md pos-relative-xs overflow-h">
                                  <img src="{{ $item->image ? url($item->image) : ''}}" alt="{{ $item->title }}" class="img-responsive img-by-h-md">
                              </div>
                              <p class="fs-12-xs pb-10-xs pt-10-xs color-gray">{{ $item->excerpt }}</p>
                              <p class="text col-xs fs-14-xs">{{ $item->title }}</p>
                              <div class="row between-xs">
                                <p class="date">{{ $item->created }}</p>
                                <p class="views">{{ $item->views }}</p>
                              </div>
                              <a href="{{ $item->url }}" title="{{$item->title}}"></a>
                          </div>
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-md-4 pl-5-xs pl-0-md pr-5-xs pr-0-md">
                  <div class="block block__1 pl-20-md block_quotes">
                    <div class="block__header row start-xs">
                      <p class="title">Партнерские продукты</p>
                    </div>
                    <div class="row block__content">
                      @foreach( $products as $item)
                          <div class="item media row no-wrap">
                              <div class="media__image col-xs">
                                <div class="image__wrapper col-xs">
                                    <img src="{{ $item->image ? url($item->image) : '' }}" alt="{{ $item->title }}">
                                </div>
                              </div>
                              <div class="media__content">
                                <p class="fw-700-xs col-xs fs-14-xs">{{ $item->title }}</p>
                                <p class="text col-xs fs-14-xs color_primary">{{ $item->excerpt }}</p>
                                <p class="date">{{ $item->created }}</p>
                              </div>
                              <a href="{{ $item->slug }}" title="{{$item->title}}"></a>
                          </div>
                      @endforeach
                    </div>
                  </div>
                </div>


              </div>

            </div>
            <div class="section pb-20-xs pb-60-md">
              <div class="row pl-5-xs pl-0-md pr-5-xs pr-0-md">
                <div class="col-xs-12">
                  <div class="block block__3">
                    <div class="block__header row between-xs bottom-xs">
                      <p class="title">Рейтинги</p>
                      <a href="{{ url('/rejtingi') }} " class="forward_button">Все рейтинги <i class="icon icon-right-open"></i></a>
                    </div>
                    <div class="row block__content">
                      @foreach( $ratings as $item)
                          <div class="item col-xs-12 col-md-4 row col">
                              <div class="h-auto-xs h-200px-md pos-relative-xs overflow-h">
                                  <img src="{{ $item->image ? url($item->image) : ''}}" alt="{{ $item->title }}" class="img-responsive img-by-h-md">
                              </div>
                              <p class="text col-xs">{{ $item->excerpt }}</p>
                              <div class="row between-xs">
                                <p class="date">{{ $item->created }}</p>
                                <p class="views">{{ $item->views }}</p>
                              </div>
                              <a href="{{ $item->url }}" title="{{$item->title}}"></a>
                          </div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>
            </div>

        </div>
    {{-- </div> --}}
@endsection
