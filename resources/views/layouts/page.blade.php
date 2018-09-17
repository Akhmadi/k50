@extends('layouts.base')

@section('styles')
    <link rel="stylesheet" href="{{ url(mix('css/app.css')) }}">
@endsection

@section('page_content')

@endsection

@section('scripts')
    <script src="{{ url(mix('js/manifest.js')) }}"></script>
    <script src="{{ url(mix('js/vendor.js')) }}"></script>
    <script src="{{ url(mix('js/app.js')) }}"></script>
@endsection