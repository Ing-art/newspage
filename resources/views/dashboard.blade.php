<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>

                <!--READER'S DASHBOARD-->

                @if(Auth::user()->hasRole('reader'))
                @if(!empty($comments))
                <h2 class="text-center mt-3 mb-3 fw-bold">My Comments</h2>
                <table class="table table-stripped table-bordered table-hover">
                    <tr class="text-center">
                        <th>Comment</th>
                        <th>Published</th>
                        <th>Article</th>
                    </tr>
                    @forelse($comments as $comment)
                    <tr class="dark:hover:bg-gray-600">
                        <td class="text-center">{{$comment->text}}</td>
                        <td class="text-center">{{$comment->created_at}}</td>
                        <td class="text-center"><a href="{{route('articles.show', $comment->article->id)}}">{{$comment->article->headline}}</a></td>
                    </tr>
                    @empty
                    <tr>
                    <td colspan="3" class="text-center">Nothing to show</td>
                    </tr>
                    @endforelse
                </table>
                @endif
                @endif

                <!--WRITER'S DASHBOARD-->
                @if(Auth::user()->hasRole('writer'))
                @if(!empty($articles))
                <h2 class="text-center mt-3 mb-3 fw-bold">Published Articles</h2>
                <table class="table table-stripped table-bordered table-hover">
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Author</th>
                        <th>Headline</th>
                        {{-- <th>Image</th> --}}
                        <th>Created</th>
                        <th>Published</th>
                        <th>Operations</th>
                    </tr>
                    @forelse($articles as $article)
                    <tr>
                        <td class="text-center">{{$article->id}}</td>
                        <td class="text-center">{{$article->user->name}}</td>
                        <td class="text-center"><a href="{{route('articles.show',$article->id)}}">{{$article->headline}}</a></td>
                        {{-- <td class="text-center" style="max-width: 80px">
                            <img class="rounded" style="max-width: 80%"
                                alt="image of {{$article->headline}}"
                                title="image of {{$article->headline}}"
                                src = "{{
                                $article->image? asset('storage/'.config('filesystems.articlesImageDir')).'/'.$article->image :
                            asset('storage/'.config('filesystems.articlesImageDir')).'/default.jpg'}}">
                        </td> --}}
                        <td class="text-center">{{$article->created_at}}</td>
                        <td class="text-center">{{$article->published_at ?? 'Not published'}}</td>
                        <td class="text-center">Operations</td>
                    </tr>
                    @empty
                    <tr>
                    <td colspan="6" class="text-center">Nothing to show</td>
                    </tr>
                    @endforelse
                </table>
                @endif
                @endif

                @if(Auth::user()->hasRole('writer'))
                @if(!empty($articles))
                <h2 class="text-center mt-3 mb-3 fw-bold">Rejected Articles</h2>
                <table class="table table-stripped table-bordered table-hover">
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Author</th>
                        <th>Headline</th>
                        {{-- <th>Image</th> --}}
                        <th>Created</th>
                        <th>Published</th>
                        <th>Operations</th>
                    </tr>

                    @forelse($articlesrejected as $article)
                    <tr>
                        <td class="text-center">{{$article->id}}</td>
                        <td class="text-center">{{$article->user->name}}</td>
                        <td class="text-center"><a href="{{route('articles.show',$article->id)}}">{{$article->headline}}</a></td>
                        {{-- <td class="text-center" style="max-width: 80px">
                            <img class="rounded" style="max-width: 80%"
                                alt="image of {{$article->headline}}"
                                title="image of {{$article->headline}}"
                                src = "{{
                                $article->image? asset('storage/'.config('filesystems.articlesImageDir')).'/'.$article->image :
                            asset('storage/'.config('filesystems.articlesImageDir')).'/default.jpg'}}">
                        </td> --}}
                        <td class="text-center">{{$article->created_at}}</td>
                        <td class="text-center">{{$article->published_at ?? 'Not published'}}</td>
                        <td class="text-center">Operations</td>
                    </tr>
                    @empty
                    <tr>
                    <td colspan="6" class="text-center">Nothing to show</td>
                    </tr>
                    @endforelse
                </table>
                @endif
                @endif
                @if(Auth::user()->hasRole('writer'))
                @if(!empty($articles))
                <h2 class="text-center mt-3 mb-3 fw-bold">Drafts</h2>
                <table class="table table-stripped table-bordered">
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Author</th>
                        <th>Headline</th>
                        {{-- <th>Image</th> --}}
                        <th>Created</th>
                        <th>Published</th>
                        <th>Operations</th>
                    </tr>
                    @forelse($drafts as $article)
                    <tr>
                        <td class="text-center">{{$article->id}}</td>
                        <td class="text-center">{{$article->user->name}}</td>
                        <td class="text-center"><a href="{{route('articles.show',$article->id)}}">{{$article->headline}}</a></td>
                        {{-- <td class="text-center" style="max-width: 80px">
                            <img class="rounded" style="max-width: 80%"
                                alt="image of {{$article->headline}}"
                                title="image of {{$article->headline}}"
                                src = "{{
                                $article->image? asset('storage/'.config('filesystems.articlesImageDir')).'/'.$article->image :
                            asset('storage/'.config('filesystems.articlesImageDir')).'/default.jpg'}}">
                        </td> --}}
                        <td class="text-center">{{$article->created_at}}</td>
                        <td class="text-center">{{$article->published_at ?? 'Not published'}}</td>
                        <td class="text-center">Operations</td>
                    </tr>
                    @empty
                    <tr>
                    <td colspan="6" class="text-center">Nothing to show</td>
                    </tr>
                    @endforelse
                </table>
                @endif
                @endif
                <!--EDITOR'S DASHBOARD-->
                @if(Auth::user()->hasRole('editor'))

                @if(!empty($articlestoreview))
                <h2 class="text-center mt-3 mb-3 fw-bold">Articles to Review</h2>
                <table class="table table-stripped table-bordered table-hover">
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Author</th>
                        <th>Headline</th>
                        {{-- <th>Image</th> --}}
                        <th>Created</th>
                        <th>Status</th>
                        <th>Operations</th>
                    </tr>
                    @forelse($articlestoreview as $article)
                    <tr>
                        <td class="text-center">{{$article->id}}</td>
                        <td class="text-center">{{$article->user->name}}</td>
                        <td class="text-center"><a href="{{route('articles.show',$article->id)}}">{{$article->headline}}</a></td>
                        {{-- <td class="text-center" style="max-width: 80px">
                            <img class="rounded" style="max-width: 80%"
                                alt="image of {{$article->headline}}"
                                title="image of {{$article->headline}}"
                                src = "{{
                                $article->image? asset('storage/'.config('filesystems.articlesImageDir')).'/'.$article->image :
                            asset('storage/'.config('filesystems.articlesImageDir')).'/default.jpg'}}">
                        </td> --}}
                        @php
                        if($article->rejected == 0)
                            $status = 'New';
                        else {
                            $status = 'Rejected';
                        }
                        @endphp
                        <td class="text-center">{{$article->created_at}}</td>
                        <td class="text-center">{{$status}}</td>
                        <td class="text-center">Operations</td>
                    </tr>
                    @empty
                    <tr>
                    <td colspan="6" class="text-center">Nothing to show</td>
                    </tr>
                    @endforelse
                </table>
                @endif
                @endif
                <!--ADMIN'S DASHBOARD-->
                @if(Auth::user()->hasRole('admin'))
                @if(!empty($users))
                <h2 class="text-center mt-3 mb-3 fw-bold">User List</h2>
                <table class="table table-stripped table-bordered table-hover">
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Name</th>
                        <th>E-mail</th>
                        <th>Roles</td>
                        <th>Operations</th>
                    </tr>
                    @forelse($users as $user)
                    <tr class="dark:hover:bg-gray-600">
                        <td class="text-center">{{$user->id}}</td>
                        <td class="text-center">{{$user->name}}</td>
                        <td class="text-center"><a href="mailto:{{$user->email}}">
                            {{$user->email}}</a></td>
                        <td class="text-center">@foreach($user->roles as $role)
                            {{$role->role}}<br>
                            @endforeach
                        </td>
                        <td class="text-center"><a class="text-decoration"
                            href="{{route('admin.users.show', $user->id)}}">Details</a></td>
                    </tr>
                    @empty
                    <tr>
                    <td colspan="4" class="text-center">Nothing to show</td>
                    </tr>
                    @endforelse
                </table>
                @endif
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
