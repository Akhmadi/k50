@extends('layouts.page')

@php
    $posts = \App\Post::reviews()->onlyEnabled()->orderBy('id', 'desc')->get();
    foreach ($posts as &$post) { $post->slug = url($post->slug); };
@endphp

@section('page_content')
    <div class="section review__section">
        <div class="container">
            <div class="block block__3 pad-5-xs pad-0-md">
                <div class="block__header row between-xs bottom-xs">
                    <p class="title">Обзоры</p>
                </div>

                @foreach ($posts->chunk(3) as $chunk)
                    <div class="row block__content">
                        @foreach ($chunk as $item)
                            <div class="col-xs-12 col-md-4 block__content_column">
                                <div class="item row col card">
                                    <div class="pos-relative-xs overflow-h h-200px-md mb-10-xs mb-20-md">
                                        <img src="{{ url($item->image) }}" alt="{{ $item->title }}" class="img-by-h-md img-responsive">
                                    </div>
                                    <p class="title col-xs">{{$item->title}}</p>
                                    <div class="row card__footer between-xs">
                                        <p class="date">{{ $item->created }}</p>
                                        {{--<p class="views">3.5k</p>--}}
                                    </div>

                                    <a href="{{ $item->url ? url($item->url) : 'javascript:;' }}" target="_blank" title="{{$item->title}}"></a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

