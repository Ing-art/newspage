@extends('layouts.master')
@section('title', 'Article')
@section('body')
    <div class="container">
        <h1 class="text-center mt-3">{{ $article->headline }}</h1>
        <p class="text-center mt-1">by {{ $article->user->name }}
        <p class="text-center mt-1>">Published on {{ \Carbon\carbon::parse($article->published_at)->format('jS F Y') }}</p>
        <figure class="text-center">
            <image class="img-fluid rounded"
                src="{{ $article->image
                    ? asset('storage/' . config('filesystems.articlesImageDir')) . '/' . $article->image
                    : asset('storage/' . config('filesystems.articlesImageDir')) . '/default.jpg' }}">

        </figure>
        <p class="text-center mt-1">Updated on {{ \Carbon\carbon::parse($article->updated_at)->format('jS F Y') }}</p>
        <h3 class="text-muted small">{{ $article->subject }}</h3>
        <p class="mt-4 text-justify">{!! nl2br($article->text) !!}</p>
        <!--Display the article with original line breaks and formats-->
        @auth
            <div class="text-center my-3">
                <div class="btn-group mx-2">
                    @if (Auth::user()->can('update', $article))
                        <a class="mx-2" href="{{ route('articles.edit', $article->id) }}">
                            <button class="btn btn-dark">Edit</button></a>
                    @endif

                    @if (Auth::user()->can('delete', $article))
                        <!--TODO QA check-->
                        <a class="mx-2" href="{{ route('articles.delete', $article->id) }}">
                            <button class="btn btn-danger">Delete</button></a>
                    @endif

                    @if (Auth::user()->can('reject', $article) && ($article->rejected == 0))
                        <a class="mx-2" href="{{ route('articles.reject', $article->id) }}">
                            <button class="btn btn-warning">Reject</button>
                        </a>
                    @endif

                    @if (Auth::user()->can('publish', $article) && ($article->published_at == NULL || $article->rejected == 1))
                        <a class="mx-2" href="{{ route('articles.publish', $article->id) }}">
                            <button class="btn btn-success">Publish</button>
                        </a>
                    @endif
                </div>
            </div>
        @endauth
        <!--COMMENT SECTION -->
        <br>
        <section class="border mt-3 mb-3" style="background-color: #ffffff;">
            <h2 class="text-center mt-1">Comments</h2>
            <div class="container my-1 py-1">
                <div class="row d-flex justify-content-left">
                    <div class="col-md-12 col-lg-10 col-xl-8">
                        <div class="card">
                            @empty($comments)
                                <p>No comments yet</p> <!--FIXME No es veu-->
                            @endempty

                            @foreach ($comments as $comment)
                                <div class="card-body">
                                    <div class="d-flex flex-start align-items-left">
                                        <div>

                                            <p class="fw-bold text-secondary mb-0">{{ $comment->user->name }}</p>
                                            <p class="text-muted small">
                                                Published -
                                                {{ \Carbon\carbon::parse($comment->created_at)->format('d-m-Y H:i:s') }}
                                            </p>
                                        </div>
                                    </div>
                                    <p class="mt-1 mb-1 pb-2 align-items-left">
                                        {{ $comment->text }}
                                    </p>
                                    @can('delete', $comment)  
                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mx-2">Delete</button>
                                    </form>
                                    @endcan
                                </div>
                            @endforeach
                            @can('create', App\Models\Comment::class)  
                           
                            <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                                <form method="POST" action="{{ route('comments.store') }}">
                                    {{ csrf_field() }}
                                    <div class="d-flex flex-start w-100">
                                        <div data-mdb-input-init class="form-outline w-100">
                                            <textarea class="form-control" name="text" id="text" rows="4" style="background: #fff;"></textarea>
                                            <input type="hidden" name="article_id" value="{{ $article->id }}">
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            <label class="form-label" for="text">Message</label>
                                        </div>
                                    </div>
                                    <div class="float-start mt-2 pt-1">
                                        <button type="submit" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-dark btn-sm">Post comment</button>
                                        <button type="reset" data-mdb-button-init data-mdb-ripple-init
                                            class="btn btn-outline-dark btn-sm">Cancel</button>
                                    </div>
                                </form>
                            </div>
                            
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </section>


    @endsection
