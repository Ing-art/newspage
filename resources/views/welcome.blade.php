@php($page = 'homepage')

@extends('layouts.master')

@section('title', 'Home')

@section('body')

    @if ($articles->currentPage() == 1) <!--only on the 1st page-->

        <!--TOP NEWS HEADER-->
        <section class="col-12 mt-4 " id="headlines">

            <div class="block-title text-center">
                <h4 class="h4 border-warning">
                    <span class="bg-warning bg-gradient text-black"><b>TOP NEWS</b></span>
                </h4>
            </div>

            <!--TOP NEWS CAROUSEL-->
            {{-- <div class="col-12 col-md-9 col-lg-9 mx-auto carousel slide card-group row row-cols-1 row-cols-md-2 g-4" id="carouselExampleInterval" data-bs-ride="carousel">
              <div class="carousel-inner"> 
                @foreach ($toparticles as $article)
                @if($loop->first)
                <div class="justify-content-center carousel-item active carousel-item bg-lg-shadow rounded position-relative" data-bs-interval="7000">
                    <img src="{{ asset('storage/'.config('filesystems.articlesImageDir')).'/'.$article->image}}"
                        class="d-block w-100 rounded" style="width: 100%; max-height: 600px; object-fit:cover" alt="{{$article->headline}}">
                    <div class="bg-lg-shadow position-absolute w-100-h-100" style="bottom:0;"></div>
                    <div class="carousel-caption">
                        <h2 class="d-block">{{$article->headline}}</h2>
                        <p class="d-none d-md-block">by {{$article->user->name}} | published {{ \Carbon\carbon::parse($article->published_at)->format('jS F Y') }}</p>
                    </div>
                </div>
                @endif
                <div class="justify-content-center carousel-item carousel-item bg-lg-shadow rounded position-relative" data-bs-interval="7000">
                    <img src="{{ asset('storage/'.config('filesystems.articlesImageDir')).'/'.$article->image}}"
                        class="d-block w-100 rounded" style="width: 100%; max-height: 600px; object-fit:cover" alt="{{$article->headline}}">
                    <div class="bg-lg-shadow position-absolute w-100-h-100" style="bottom:0;"></div>
                    <div class="carousel-caption">
                        <h2 class="d-block">{{$article->headline}}</h2>
                        <p class="d-none d-md-block">by {{$article->user->name}} | published {{ \Carbon\carbon::parse($article->published_at)->format('jS F Y') }}</p>
                    </div>
                </div>
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
            </div> --}}
            
            <div class="col-12 col-md-9 col-lg-9 mx-auto carousel slide card-group row row-cols-1 row-cols-md-2 g-4" id="carouselExampleInterval" data-bs-ride="carousel">
                <div class="carousel-inner">
                  @foreach ($toparticles as $article)
                    <div class="justify-content-center carousel-item bg-lg-shadow rounded position-relative overflow-hidden @if($loop->first) active @endif" data-bs-interval="7000">
                      <img src="{{ $article->image 
                                ? asset('storage/' . config('filesystems.articlesImageDir')) . '/' . $article->image
                                        : asset('storage/' . config('filesystems.articlesImageDir')) . '/default.jpg' }}"
                           class="d-block w-100 rounded" style="width: 100%; max-height: 700px; object-fit:cover" alt="{{$article->headline}}">
                      <div class="bg-lg-shadow position-absolute w-100-h-100" style="bottom:0;"></div>
                      <div class="carousel-caption">
                        <a href="{{ route('articles.show', $article->id) }}"
                            class="text-decoration-none link-light"><h2 class="d-block">{{$article->headline}}</h2></a>
                        <p class="d-none d-md-block">by {{$article->user->name}} | published {{ \Carbon\Carbon::parse($article->published_at)->format('jS F Y') }}</p>
                      </div>
                    </div>
                  @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
                         
        </section>
    @endif

    <!--MORE  NEWS SECTION-->

    <section class="col-12 mt-4" id="morenews">

        <div class="block-title text-center">
            <h4 class="h4 border-warning">
                <span class="bg-warning bg-gradient text-black"><b>MORE NEWS</b></span>
            </h4>
        </div>

        <!--MORE NEWS CONTENT BLOCK-->
        <div class="container mt-5">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($articles as $article)
                    <div class="col">
                        <div class="card mb-3 h-100">
                            <div class="card-img-container rounded-top">
                                <img class="card-img-top"
                                    src="{{ $article->image
                                        ? asset('storage/' . config('filesystems.articlesImageDir')) . '/' . $article->image
                                        : asset('storage/' . config('filesystems.articlesImageDir')) . '/default.jpg' }}"
                                    alt="...">
                            </div>
                            <div class="card-body text-white bg-dark">
                                <a href="{{ route('articles.show', $article->id) }}"
                                    class="text-decoration-none link-light">
                                    <h4 class="card-title"><b>{{ $article->headline }}</b></h4>
                                </a>
                                <div>
                                    <span class="card-text text-warning small">{{ $article->subject }} | </span>
                                    <span class="card-text small">By {{ $article->user->name }}</span>
                                </div>
                                <p class="card-text line-clamp text-justify mt-2">{!! nl2br($article->text) !!}</p>
                            </div>
                            <div class="card-footer text-white bg-dark rounded-bottom">
                                <small
                                    class="text-white">{{ \Carbon\carbon::parse($article->published_at)->format('jS F Y') }}</small>
                                <small class="text-white d-none d-md-block">
                                    <i class="fas fa-eye"></i> {{ $article->visits }}
                                </small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!--PAGINATION LINKS-->

        <div class="col-12 d-flex justify-content-center mt-4">{{ $articles->links() }}</div>
    </section>
    </div>
@endsection
