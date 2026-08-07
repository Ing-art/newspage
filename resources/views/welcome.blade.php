@php($page = 'homepage')

@extends('layouts.master')

@section('title', 'Home')

@section('body')
    @if ($articles->currentPage() == 1) <!-- only on the first page -->
        <section class="hero-stories editorial-section" id="headlines" aria-labelledby="top-news-title">
            <div class="section-heading">
                <p class="section-kicker">Editor's selection</p>
                <h2 id="top-news-title">Top News</h2>
            </div>

            <div class="carousel slide hero-carousel" id="carouselExampleInterval" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach ($toparticles as $article)
                        <article class="carousel-item position-relative overflow-hidden @if ($loop->first) active @endif"
                            data-bs-interval="7000">
                            <img src="{{ $article->image
                                ? asset('storage/' . config('filesystems.articlesImageDir')) . '/' . $article->image
                                : asset('storage/' . config('filesystems.articlesImageDir')) . '/default.jpg' }}"
                                class="d-block w-100 hero-image" alt="{{ $article->headline }}">
                            <div class="hero-overlay" aria-hidden="true"></div>
                            <div class="carousel-caption hero-caption text-start">
                                <p class="story-meta mb-2">{{ $article->subject }}</p>
                                <a href="{{ route('articles.show', $article->id) }}" class="story-link">
                                    <h3>{{ $article->headline }}</h3>
                                </a>
                                <p class="hero-byline mb-0">
                                    By {{ $article->user->name }}
                                    <span aria-hidden="true">·</span>
                                    {{ \Carbon\Carbon::parse($article->published_at)->format('jS F Y') }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>
    @endif

    <section class="editorial-section latest-stories" id="morenews" aria-labelledby="more-news-title">
        <div class="section-heading">
            <p class="section-kicker">Latest stories</p>
            <h2 id="more-news-title">More News</h2>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-4">
            @foreach ($articles as $article)
                <div class="col">
                    <article class="card article-card h-100">
                        <a class="card-image-link" href="{{ route('articles.show', $article->id) }}"
                            aria-label="Read {{ $article->headline }}">
                            <div class="card-img-container">
                                <img class="card-img-top"
                                    src="{{ $article->image
                                        ? asset('storage/' . config('filesystems.articlesImageDir')) . '/' . $article->image
                                        : asset('storage/' . config('filesystems.articlesImageDir')) . '/default.jpg' }}"
                                    alt="{{ $article->headline }}">
                            </div>
                        </a>

                        <div class="card-body">
                            <p class="story-meta mb-2">{{ $article->subject }}</p>
                            <a href="{{ route('articles.show', $article->id) }}" class="story-link">
                                <h3 class="card-title">{{ $article->headline }}</h3>
                            </a>
                            <p class="card-byline mb-3">By {{ $article->user->name }}</p>
                            <div class="card-text line-clamp">{!! nl2br($article->text) !!}</div>
                        </div>

                        <footer class="card-footer d-flex align-items-center justify-content-between">
                            <time datetime="{{ \Carbon\Carbon::parse($article->published_at)->toDateString() }}">
                                {{ \Carbon\Carbon::parse($article->published_at)->format('jS F Y') }}
                            </time>
                            <span class="story-views" aria-label="{{ $article->visits }} views">
                                <i class="fas fa-eye" aria-hidden="true"></i> {{ $article->visits }}
                            </span>
                        </footer>
                    </article>
                </div>
            @endforeach
        </div>

        <nav class="pagination-wrapper d-flex justify-content-center" aria-label="News pagination">
            {{ $articles->links() }}
        </nav>
    </section>
@endsection
