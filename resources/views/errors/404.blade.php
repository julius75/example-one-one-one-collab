@extends('errors.layout')

@section('code', '404')
@section('title', 'Page Not Found')

@section('image')
    <div style="background-image: url('/svg/404.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@section('message')
    You seem to have upset the delicate internal balance of my housekeeper.
    <br/>
    {{ $exception->getMessage() }}
@endsection
