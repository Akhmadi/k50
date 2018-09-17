@extends('layouts.page')

@php
    $posts = \App\Post::initiatives()->onlyEnabled()->orderBy('id', 'desc')->get();
@endphp

@section('page_content')
    <div class="section initiatives__section">
        <div class="container">
            <div class="block block__3">
                <div class="block__header row between-xs bottom-xs mar-5-xs mar-0-md">
                    <p class="title">Инициативы</p>
                </div>

                @foreach ($posts->chunk(3) as $chunk)
                    <div class="row block__content pad-5-xs pad-0-md">
                        @foreach ($chunk as $item)
                            <div class="col-xs-12 col-md-4 block__content_column mb-10-xs mb-0-md">
                                <div class="item row col card">
                                    <div class="image__wrapper">
                                        <img src="{{ url($item->image) }}" alt="{{ $item->title }}">
                                    </div>
                                    <p class="title col-xs">{{$item->title}}</p>
                                    <p class="text col-xs">{{$item->excerpt}}</p>
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
        </div>
    </div>
@endsection

