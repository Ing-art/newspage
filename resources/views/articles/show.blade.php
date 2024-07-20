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
            <p class="mt-4 text-justify">{!!nl2br($article->text)!!}</p> <!--Display the article with original line breaks and formats-->
            @auth
            <div class="text-center my-3">
                <div class="btn-group mx-2">
                    @if(Auth::user()->can('update', $article))
                    <a class="mx-2" href="{{route('articles.edit', $article->id)}}">
                        <button class="btn btn-dark">Edit</button></a>
                    @endif

                    {{-- @if(Auth::user()->can('delete', $article)) --}}<!--TODO-->
                    <a class="mx-2" href="{{route('articles.delete', $article->id)}}">
                        <button class="btn btn-danger">Delete</button></a>
                    {{-- @endif --}}
                     
                    @if(Auth::user()->can('reject', $article))
                    <a class="mx-2" href="{{ route('articles.reject', $article->id) }}">
                        <button class="btn btn-warning">Reject</button>
                    </a>
                    @endif

                    @if(Auth::user()->can('publish', $article))
                    <a class="mx-2" href="{{ route('articles.publish', $article->id) }}">
                        <button class="btn btn-success">Publish</button>
                    </a>
                    @endif
                </div>
            </div>
            @endauth
@endsection           
    
    