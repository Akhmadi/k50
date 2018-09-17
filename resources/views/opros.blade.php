@extends('layouts.page')

@php
    $post = \App\Post::questions()->bySlug($params['slug']['value'])->first();
@endphp

@section('page_content')
    @include('templates.simple_post', ['post' => $post])
@endsection

