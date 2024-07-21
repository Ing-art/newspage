@extends('layouts.master')
@section('title', 'Delete Article')
@section('body')
        @if(Auth::user()->can('delete', $article))<!--TODO QA check-->
        <form method="POST" clas="my-2 border p-5" action="{{URL::temporarySignedRoute('articles.destroy',now()->addMinutes(1), $article->id)}}">
            {{ csrf_field()}}
            <input name="_method" type="hidden" value="DELETE">
            <label for="confirmdelete">Confirm you want to delete the article "{{"$article->headline?"}}":</label>
            <input type="submit" alt="Delete" title="Delete" class="btn btn-danger m-4" value="Delete" id="confirmdelete">
        </form>
        
{{--         <div class="btn-group" role="group" aria-label="Links">
            <a href="{{route('articles.show', $article->id)}}" class="btn btn-secondary m-2">Go Back</a>
        </div> --}}
        @endauth
@endsection           
    
    