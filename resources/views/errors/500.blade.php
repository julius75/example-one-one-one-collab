@extends('errors.layout')

@section('code', '500')
@section('title', 'Error')

@section('image')
    <div style="background-image: url('/svg/500.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
    </div>
@endsection

@php
    $e_message = $exception->getMessage() ? $exception->getMessage() : 'Something is just not right!. Please inform the IT department ASAP! before performing this action again';
@endphp

@section('message', $e_message)
