@php($page='homepage')

@extends('layouts.master')

@section('title', 'Home')

@section('body')

        @if ($articles->currentPage() == 1)
            <!--TOP NEWS-->
            <section class="col-12 mt-4" id="headlines">
                
                <div class="block-title text-center">
                    <h4 class="h4 border-warning">
                        <span class="bg-warning text-black"><b>TOP NEWS</b></span>
                    </h4>
                </div>
                <div class="card-group row row-cols-1 row-cols-md-2 g-4">
                    @foreach($toparticles as $toparticle)
                    <div class="col">
                        <article class="card bg-dark text-white zoom overflow-hidden rounded">
                            <img class="card-img img-fluid " src="{{ asset('images/articles/test.jpeg') }}">
                            <div class="card-img-overlay d-flex flex-column justify-content-end bg-lg-shadow">
                                <div class="w-100 p-3 m-0">
                                    <span class="card-text d-none d-md-block">{{$toparticle->subject}}</span>
                                    <h3 class="card-title">{{$toparticle->headline}}</h3>
                                    <div>
                                        <span class="card-text d-none d-md-block">by {{$toparticle->user->name}}</span>
                                        <span class="card-text d-none d-md-block">Last Updated: xxxx</span>
                                    </div>
                                </div>
                            </div>
                        </article>
 {{--                    </div>
                    <div class="col">
                        <article class="card bg-dark text-white zoom overflow-hidden">
                            <img class="card-img img-fluid" src="{{ asset('images/articles/test.jpeg') }}">
                            <div class="card-img-overlay d-flex flex-column justify-content-end bg-lg-shadow">
                                <div class="w-100 p-3 m-0">
                                    <h3 class="card-title ">Bear wants to be the next president</h3>
                                    <div>
                                        <span class="card-text d-none d-md-block">by Author |</span>
                                        <span class="card-text d-none d-md-block">Last Updated: xxxx</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div> --}}
                    
                </div>
                @endforeach
            </section>
        @endif
        <!--MORE  NEWS SECTION-->

        <section class="col-12 mt-4" id="morenews">

            <div class="block-title text-center">
                <h4 class="h4 border-warning">
                    <span class="bg-info text-black"><b>OTHER NEWS</b></span>
                </h4>
            </div>
            
            <!--MORE NEWS CONTENT BLOCK-->
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach ($articles as $article)
                    <div class="col">
                        <div class="card h-100">
                            <img src="{{ asset('images/articles/test.jpeg') }}" class="card-img-top rounded" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><b>{{ $article->headline }}</b></h5>
                                <div>
                                    <span class="card-text text-muted small">{{$article->subject}} | </span>
                                    <span class="card-text text-muted small">By {{ $article->user->name }}</span>
                                </div>
                                <p class="card-text line-clamp">{{ $article->text }}</p>
                            </div>
                            <div class="card-footer">
                                <small class="text-muted">Last updated 3 mins ago</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!--pagination links-->

            <div class="col-12 d-flex justify-content-center mt-4">{{ $articles->links() }}</div>         
        </section>
    </div>
    @endsection

