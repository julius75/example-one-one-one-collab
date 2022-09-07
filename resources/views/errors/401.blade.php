@extends('errors.layout')

@section('code', '401')
@section('title', 'Unauthorized')

@section('image')
    <div style="background-image: url('/svg/403.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection


@section('message')
    @if ($error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endif
@endsection
