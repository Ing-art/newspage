@php($page='homepage')

@extends('layouts.master')

@section('title', 'Home')

@section('body')

        @if ($articles->currentPage() == 1) <!--only on the 1st page-->

            <!--TOP NEWS-->
            <section class="col-12 mt-4 " id="headlines">

                <div class="block-title text-center">
                    <h4 class="h4 border-warning">
                        <span class="bg-warning bg-gradient text-black"><b>TOP NEWS</b></span>
                    </h4>
                </div>
                <div class="card-group row row-cols-1 row-cols-md-2 g-4 ">
                    @foreach($toparticles as $toparticle)
                    <div class="col d-flex ">
                        <article class="card bg-dark text-white zoom overflow-hidden rounded" style="height:500px width:auto">
                            <img class="card-img img-fluid " src="{{
                                $toparticle->image ?
                                asset('storage/'.config('filesystems.articlesImageDir')).'/'.$toparticle->image:
                                asset('storage/'.config('filesystems.articlesImageDir')).'/default.jpg'}}">
                            <div class="card-img-overlay d-flex flex-column justify-content-end bg-lg-shadow">
                                <div class="w-100 p-3 m-0">
                                    <span class="card-text text-warning d-none d-md-block">{{$toparticle->subject}}</span>
                                    <a href="{{route('articles.show', $toparticle->id)}}" class="text-decoration-none text-light"><h3 class="card-title">{{$toparticle->headline}}</h3></a>
                                    <div>
                                        <span class="card-text d-none d-md-block">by {{$toparticle->user->name}} | {{\Carbon\carbon::parse($toparticle->published_at)->format('jS F Y')}}</span>
                                        <small class="text-white d-none d-md-block">
                                            <i class="fas fa-eye"></i> {{$toparticle->visits}}
                                          </small>
                                        {{-- <span class="card-text d-none d-md-block">Published on {{\Carbon\carbon::parse($toparticle->published_at)->format('jS F Y')}}</span> --}}
                                    </div>
                                </div>
                            </div>
                        </article>
                </div>
                @endforeach
            </section>
        @endif

        <!--MORE  NEWS SECTION-->

        <section class="col-12 mt-4" id="morenews">

            <div class="block-title text-center">
                <h4 class="h4 border-warning">
                    <span class="bg-warning bg-gradient text-black"><b>OTHER NEWS</b></span>
                </h4>
            </div>

            <!--MORE NEWS CONTENT BLOCK-->
            <div class="container mt-5">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                  @foreach ($articles as $article)
                    <div class="col">
                      <div class="card mb-3 h-100 rounded">
                        <div class="card-img-container">
                          <img class="card-img-top" src="{{
                            $article->image ?
                            asset('storage/'.config('filesystems.articlesImageDir')).'/'.$article->image :
                            asset('storage/'.config('filesystems.articlesImageDir')).'/default.jpg'
                          }}" alt="...">
                        </div>
                        <div class="card-body text-white bg-dark">
                          <a href="{{ route('articles.show', $article->id) }}" class="text-decoration-none link-light">
                            <h4 class="card-title"><b>{{ $article->headline }}</b></h4>
                          </a>
                          <div>
                            <span class="card-text text-warning small">{{ $article->subject }} | </span>
                            <span class="card-text small">By {{ $article->user->name }}</span>
                          </div>
                          <p class="card-text line-clamp text-justify mt-2">{!! nl2br($article->text) !!}</p>
                        </div>
                        <div class="card-footer text-white bg-dark">
                          <small class="text-white">{{\Carbon\carbon::parse($article->published_at)->format('jS F Y')}}</small>
                          <small class="text-white d-none d-md-block">
                            <i class="fas fa-eye"></i> {{$article->visits}}
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

