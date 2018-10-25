@extends('layouts.page')

@php

    if (!empty($params['category']['value'])){
        $posts = \App\Post::ratings()->onlyEnabled()->byPostCategory($params['category']['value'])->get();

        $postCat = \App\PostCategory::where('slug', $params['category']['value'])->first();

    } else {
        $postCats = \App\PostCategory::enabled()->byPostTypeCode(\App\PostType::POST_TYPE_RATING)->get();
    }

@endphp

@section('page_content')
    <div class="section initiatives__section">
        <div class="container">
            @if (empty($params['category']['value']))
                <div class="block block__3">

                <div class="block__header row between-xs bottom-xs">
                    <p class="title">Номинации</p>
                </div>
                @foreach ($postCats->chunk(3) as $chunk)
                    <div class="row block__content">
                        @foreach ($chunk as $item)
                            <div class="col-xs-12 col-md-4 block__content_column">
                                <div class="item row col card">
                                    <div class="image__wrapper">
                                        <img src="{{ $item->image ? url($item->image) : '' }}" alt="{{ $item->title }}">
                                    </div>
                                    <p class="title col-xs">{{$item->title}}</p>
                                    <div class="row card__footer between-xs">
                                    </div>
                                    <a href="{{ \App\PagesService::pageRoute('ratings', ['category' => $item->slug]) }}" title="{{$item->title}}"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                </div>
            @else
                <div class="block block__3 pad-5-xs pad-0-md">
                    <div class="block__header row between-xs bottom-xs">
                        <p class="title">{{ isset($postCat) && $postCat ? $postCat->title : 'Рейтинги' }}</p>
                    </div>

                    @foreach ($posts->chunk(3) as $chunk)
                        <div class="row block__content">
                            @foreach ($chunk as $item)
                                <div class="col-xs-12 col-md-4 block__content_column">
                                    <div class="item row col card">
                                        <div class="image__wrapper">
                                            <img src="{{ url($item->image) }}" alt="{{ $item->title }}">
                                        </div>
                                        <p class="title col-xs">{{$item->title}}</p>
                                        <div class="row card__footer between-xs">
                                            <p class="date">{{ $item->created }}</p>
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
        </div>
    </div>

@endsection

