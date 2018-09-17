@extends('layouts.page')

@php
    $posts = \App\Post::news()->onlyEnabled()->select(['title', 'image','slug','excerpt','created_at','post_type_id', 'views'])->with(['postType.page'])->orderBy('id', 'desc')->get();
@endphp

@section('page_content')
    <div class="section news__section">
        <div class="container">
            <div class="block block__3">
                <div class="block__header row between-xs bottom-xs mar-5-xs mar-0-md">
                    <p class="title">Новости</p>
                </div>

                @foreach ($posts->chunk(3) as $chunk)
                    <div class="row block__content">
                        @foreach ($chunk as $item)
                            <div class="col-xs-12 col-md-4 block__content_column mb-20-xs mb-0-md">
                                <div class="item row col card">
                                    <div class="pos-relative-xs h-200px-xs mb-10-xs overflow-h">
                                        <img src="{{ url($item->image) }}" alt="{{ $item->title }}" class="img-by-w-xs img-by-h-md">
                                    </div>
                                    <p class="fs-12-xs pb-10-xs pt-10-xs pl-15-xs pr-15-xs color-gray">{{ $item->excerpt }}</p>
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
            {{--{{ $posts->links() }}--}}

        </div>
    </div>

@endsection

