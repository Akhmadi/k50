@extends('layouts.page')

@php
    if ( $post = \App\Post::ratings()->bySlug($params['slug']['value'])->first() ) {

        App\Post::where('id', $post->id)->increment('views');

        $post->ratingPersons = $post->ratingPersons->sortBy(function($person){
            return $person->ratingPivot;
        });
    }
@endphp

@section('page_content')
    <div class="section is__paddingless rating__section">
        @if(isset($post))
            <div class="container">
                <img src="{{ url($post->image) }}" alt="{{ $post->title }}" class="img-responsive">
            </div>
            <div class="container pt-80-md pt-20-xs pb-80-md pb-20-xs">
                <div class="section__header pad-5-xs">
                    <h3>{{ $post->title }}</h3>
                    <p class="date hidden-xs block-md">{{ $post->created }}</p>
                </div>
                <div class="base__content content">
                    {!! $post->body !!}
                </div>
                <div class="row center-xs">
                    @foreach($post->ratingPersons as $ratingPerson)
                        <div class="col-xs-12 col-md-1-5 pad-5-xs col">
                            <div class="card-image h-300px-xs pos-relative-xs overflow-h">
                                <img src="{{ url($ratingPerson->image) }}" alt="{{ $ratingPerson->name }}" class="img-by-h-xs">
                            </div>
                            <p class="fs-18-xs fw-700-xs pb-5-xs pt-5-xs col-xs">{{ $ratingPerson->name }}</p>
                            <p class="fs-16-xs ta-l-xs">{{ $ratingPerson->descriptionPivot }}</p>
                        </div>
                        {{--<div class="person mb-20-xs mb-0-md">--}}
                            {{--<div class="image__wrapper">--}}
                                {{--<img src="{{ url($ratingPerson->image) }}" alt="{{ $ratingPerson->name }}">--}}
                            {{--</div>--}}
                            {{--<p class="name fw-700-xs fw-400-md pad-5-xs"><span class="hidden-md">{{ $ratingPerson->ratingPivot }}. </span>{{ $ratingPerson->name }}</p>--}}
                            {{--<p class="description pad-5-xs">{{ $ratingPerson->descriptionPivot }}</p>--}}
                        {{--</div>--}}
                    @endforeach
                </div>

            </div>
        @else
            <p>ничего не найдено</p>
        @endif
    </div>
@endsection

