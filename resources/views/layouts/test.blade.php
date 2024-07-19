

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
              <span class="card-text small">{{ $article->subject }} | </span>
              <span class="card-text small">By {{ $article->user->name }}</span>
            </div>
            <p class="card-text line-clamp text-justify mt-2">{!! nl2br($article->text) !!}</p>
          </div>
          <div class="card-footer text-white bg-dark">
            <small class="text-white">Last updated 3 mins ago</small>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>


