@extends('layouts.master')
@section('title', 'article')
@section('body')
<div class="container">
    <h1 class="text-center mt-3">{{$article->headline}}</h1>
        <p class="text-center mt-1">by {{$article->user->name}}
            <p class="text-center mt-1>">Published on {{\Carbon\carbon::parse($article->published_at)->format('jS F Y')}}</p>
            <figure class="text-center">
                <image class="img-fluid rounded" src="{{
                    $article->image ?
                    asset('storage/'.config('filesystems.articlesImageDir')).'/'.$article->image:
                    asset('storage/'.config('filesystems.articlesImageDir')).'/default.jpg'}}">

            </figure>
            <h3 class="text-muted small">{{$article->subject}}</h3>
            <p class="mt-4 text-justify">{!!nl2br($article->text)!!}</p>

            <div class="text-end my-3">
                <div class="btn-group mx-2">
                    {{-- @if(Auth::user()->can('update', $article)) --}}<!--TODO-->
                    <a class="mx-2" href="{{route('articles.edit', $article->id)}}">Edit </a>
                    {{-- @endif --}}
                    {{-- @if(Auth::user()->can('delete', $article)) --}}
                    <a class="mx-2" href="{{route('articles.delete', $article->id)}}">Delete</a>
                    {{-- @endif --}}
                </div>
            </div>
@endsection           
    
    