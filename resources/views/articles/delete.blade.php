@extends('layouts.master')
@section('title', 'Delete Article')
@section('body')
        @if(Auth::user()->can('delete', $article))
        <form method="POST" clas="my-2 border p-5" action="{{URL::temporarySignedRoute('articles.destroy',now()->addMinutes(1), $article->id)}}">
            {{ csrf_field()}}
            <input name="_method" type="hidden" value="DELETE">
            <label for="confirmdelete">Confirm you want to delete the article "{{"$article->headline?"}}":</label>
            <input type="submit" alt="Delete" title="Delete" class="btn btn-danger m-4" value="Delete" id="confirmdelete">
        </form>
        
        @endauth
@endsection           
    
    