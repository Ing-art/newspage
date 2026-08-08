@extends('layouts.master')
@section('title', 'Article')
@section('body')

    <div class="container">
        <h1 class="text-center mt-3">{{ $article->headline }}</h1>
        <p class="text-center mt-1">by {{ $article->user->name }}
        <p class="text-center mt-1>">Published on {{ \Carbon\carbon::parse($article->published_at)->format('jS F Y') }}</p>
        <figure class="text-center">
            <image class="img-fluid rounded" style="max-width: 100%; max-height: 600px; object-fit:cover"
                src="{{ $article->image
                    ? asset('storage/' . config('filesystems.articlesImageDir')) . '/' . $article->image
                    : asset('storage/' . config('filesystems.articlesImageDir')) . '/default.jpg' }}">

        </figure>
        <p class="text-center mt-1 small">Updated on {{ \Carbon\carbon::parse($article->updated_at)->format('jS F Y') }}</p>
        <h3 class="text-muted">{{ $article->subject }}</h3>
        <div class="d-flex justify-content-end">
        <button type="button" class="btn btn-secondary position-relative text-right">
            Visits
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
              {{$article->visits}}
              <span class="visually-hidden">Views</span>
            </span>
          </button>
        </div>
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
                        <a class="mx-2" href="{{ route('articles.delete', $article->id) }}">
                            <button class="btn btn-danger">Delete</button></a>
                    @endif

                    @if (Auth::user()->can('submit', $article))
                        <form class="d-inline" method="POST" action="{{ route('articles.submit', $article->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success mx-2" type="submit">Submit</button>
                        </form>
                    @endif

                    @if (Auth::user()->can('reject', $article))
                        <form class="d-inline" method="POST" action="{{ route('articles.reject', $article->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-warning mx-2" type="submit">Reject</button>
                        </form>
                    @endif

                    @if (Auth::user()->can('publish', $article))
                        <form class="d-inline" method="POST" action="{{ route('articles.publish', $article->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success mx-2" type="submit">Publish</button>
                        </form>
                    @endif

                    @if (Auth::user()->can('unpublish', $article) && $article->published_at !== null)
                        <form class="d-inline" method="POST" action="{{ route('articles.unpublish', $article->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-warning mx-2" type="submit">Unpublish</button>
                        </form>
                    @endif

                    @if (Auth::user()->can('maketopnews', $article) && $article->published_at !== null && $article->istopnews == 0)
                        <form class="d-inline" method="POST" action="{{ route('articles.maketopnews', $article->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-success mx-2" type="submit">Top News</button>
                        </form>
                    @endif

                    @if (Auth::user()->can('removetopnews', $article) && $article->published_at !== null && $article->istopnews == 1)
                        <form class="d-inline" method="POST" action="{{ route('articles.removetopnews', $article->id) }}">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-danger mx-2" type="submit">Remove Top News</button>
                        </form>
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
                            @if(!$comments->count())
                                <p>No comments yet</p>
                            @endif
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
