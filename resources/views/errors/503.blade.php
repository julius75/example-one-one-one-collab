@extends('errors.layout')

@section('code', 'Hmm')
@section('title', '503')

@section('image')
    <div style="background-image: url('/svg/503.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message')
    {{ $exception->getMessage() ?: 'Fixing a few loose strings. We\'ll be right back in a few' }}
    <br/>
    <br/>
    In the meantime: Remember to be kind always!
@endsection
