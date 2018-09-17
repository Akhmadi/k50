@extends('layouts.page')

@php
    $featurePosts = cache('cached.featuredEvents');

    $pastPosts = cache('cached.pastEvents')->sortByDesc('eventDate');

    $post = $featurePosts->first();

@endphp

@section('page_content')
    <div class="section events__section">
        <div class="container">

            @if($featurePosts->count())
            <div class="block block__3 pad-5-xs pad-0-md mb-20-md">
                <div class="block__header row between-xs bottom-xs">
                    <p class="title">Следующее событие</p>
                </div>
                <div class="block__content">
                    <div class="card card_large">
                        <div class="img__wrapper">
                            <img class="img-by-w-md img-by-h-xs" src="{{ url($post->image) }}" alt="{{ $post->title }}">
                        </div>
                        <div class="card__content">
                            <p class="title">{{ $post->title }}</p>
                            <p class="text ">{{ $post->excerpt }}</p>
                            <p class="date">{{ getFormattedDate($post->eventDate) }}</p>
                            <p class="views">{{ $post->views }}</p>
                        </div>
                        <a href="{{ $post->url ? url($post->url) : 'javascript:;' }}" title="{{$post->title}}" class="card__url"></a>
                    </div>
                </div>

            </div>
            @endif


            @if($featurePosts->count())
            <div class="block block__3 pad-5-xs pad-0-md mb-20-md">
                <div class="block__header row between-xs bottom-xs">
                    <p class="title">Грядущие события</p>
                </div>

                @foreach ($featurePosts->chunk(3) as $chunk)
                    <div class="row block__content">
                        @foreach ($chunk as $item)
                            <div class="col-xs-12 col-md-4 block__content_column mb-20-xs mb-0-md">
                                <div class="item row col card ">
                                    <div class="h-200px-xs pos-relative-xs overflow-h mb-10-xs">
                                        <img src="{{ url($item->image) }}" alt="{{ $item->title }}" class="img-by-h-md img-responsive">
                                    </div>
                                    <p class="title">{{ $item->title }}</p>
                                    <p class="text col-xs">{{ $item->excerpt }}</p>
                                    <div class="row card__footer between-xs">
                                        <p class="date">{{ getFormattedDate($item->eventDate) }}</p>
                                        <p class="views">{{ $item->views }}</p>
                                    </div>

                                    <a href="{{ $item->url ? url($item->url) : 'javascript:;' }}" title="{{$item->title}}"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            @endif

            <div class="block block__3 pad-5-xs pad-0-md">
                <div class="block__header row between-xs bottom-xs">
                    <p class="title">Предыдущие события</p>
                </div>

                @foreach ($pastPosts->chunk(3) as $chunk)
                    <div class="row block__content">
                        @foreach ($chunk as $item)
                            <div class="col-xs-12 col-md-4 block__content_column mb-20-xs mb-0-md">
                                <div class="item row col card">
                                    <div class="h-200px-xs pos-relative-xs overflow-h mb-10-xs">
                                        <img src="{{ url($item->image) }}" alt="{{ $item->title }}" class="img-by-h-md img-responsive">
                                    </div>
                                    <p class="title">{{$item->title}}</p>
                                    <p class="text col-xs">{{ $item->excerpt }}</p>
                                    <div class="row card__footer between-xs">
                                        <p class="date">{{ getFormattedDate($item->eventDate) }}</p>
                                        <p class="views">{{ $item->views }}</p>
                                    </div>

                                    <a href="{{ $item->url ? url($item->url) : 'javascript:;' }}" title="{{$item->title}}"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

