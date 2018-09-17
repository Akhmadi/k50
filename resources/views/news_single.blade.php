@extends('layouts.page')

@php
    $post = \App\Post::news()->onlyEnabled()->bySlug($params['slug']['value'])->first();

    $post->views = $post->views + 1;
    $post->save();

    $posts = \App\Post::news()->onlyEnabled()->orderBy('id', 'desc')->take(6)->get();
@endphp

@section('og')
    @if($post)
    <meta property="og:url"                content="{{ url()->current() }}" />
    <meta property="og:type"               content="article" />
    <meta property="og:title"              content="{{ $post->title }}" />
    <meta property="og:description"        content="{{ $post->excerpt }}" />
    <meta property="og:image"              content="{{ url($post->image) }}" />
    @endif
@endsection

@section('page_title', $post->title)

@section('page_content')
    <div class="section section_post news__section">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-md-8">
                    @if(isset($post))
                        <div class="block">
                            <div class="block__header mar-5-xs mar-0-md">
                                <div class="title">{{ $post->title }}</div>
                            </div>

                            <div class="block__content">
                                <div class="title__image image__wrapper">
                                    <img src="{{ url($post->image) }}" alt="{{ $post->title }}">
                                </div>
                                <div class="row description">
                                    <div class="col-xs-6 stats">
                                        <span class="date">{{ $post->created }}</span>
                                        <span class="views">{{ $post->views }}</span>
                                    </div>
                                    <ul class="col-xs-6 socials">
                                        <li class="socials__item">
                                            <a class="share-data" role="button"
                                               data-url="{{ $post->url }}"
                                               data-provider="facebook"
                                               data-title="{{ $post->title }}"
                                               data-image="{{ url($post->image) }}"
                                               data-desc="{{ $post->excerpt }}"><i class="icon icon-facebook"></i></a>
                                        </li>
                                        <li class="socials__item">
                                            <a class="share-data" role="button"
                                               data-provider="twitter"
                                               data-url="{{ $post->url }}"
                                               data-title="{{ $post->title }}"
                                               data-image="{{ url($post->image) }}"
                                               data-desc="{{ $post->excerpt }}"><i class="icon icon-twitter"></i></a>
                                        </li>
                                        <li class="socials__item">
                                            <a class="share-data" role="button"
                                               data-provider="linkedin"
                                               data-url="{{ $post->url }}"
                                               data-title="{{ $post->title }}"
                                               data-image="{{ url($post->image) }}"
                                               data-desc="{{ $post->excerpt }}"><i class="icon icon-linkedin"></i></a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="content pad-5-xs pad-0-md">
                                    {!! $post->body !!}
                                </div>
                            </div>
                        </div>
                    @else
                        <p>ничего не найдено</p>
                    @endif
                </div>
                <div class="col-xs-12 col-md-4 sidebar sidebar_right">
                    <div class="block pad-5-xs pad-0-md">
                        <div class="block__header ">
                            <div class="title">Остальные статьи</div>
                        </div>

                        <div class="block__content row ">
                            @foreach( $posts as $post)
                                <div class="col-xs-12 ">
                                    <div class="pointed-list-item">
                                        <div class="point"></div>
                                        <div class="content row between-xs end-xs">
                                            <p class="date">{{ $post->created }}</p>
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
            </div>
        </div>
    </div>
@endsection

