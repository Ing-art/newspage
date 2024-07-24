@php('blocked')
@extends('layouts.master')
@section('body')

<div class="container row mt-2">
    <div class="col-12 alert alert-danger p-4">
        <p>You have been <b>blocked</b> by the admin</p>
        <p>Please <a href="{{route('contact')}}">contact us </a> for more details</p>
    </div>
</div>
@endsection
