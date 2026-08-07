<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Madworld News Dashboard') }}
        </h2>
    </x-slot>


    <div class="container col-12 mt-3">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 fw-bold">
                    {{ __("You're logged in!") }} {{ Auth::user()->name }}
                </div>

                <!--USER'S DETAILS-->
                <div class=" p-6 row row-cols-1 row-cols-md-2 g-4 text-start text-gray-900 dark:text-gray-100">
                    <table class="table">
                        <tr>
                            <td>Your role: </td>
                        </tr>
                        <tr>
                            <td class="text-center">
                                @foreach (Auth::user()->roles as $role)
                                    <h6 class="fw-bold"> {{ $role->role }}</h6>
                                @endforeach
                            </td>
                        </tr>
                    </table>
                </div>


                <!--READER'S DASHBOARD-->

                @if (Auth::user()->hasRole('reader'))
                    <div class="container col-12 card text-center">
                        @if (!empty($comments))
                            <h2 class="text-center mt-3 mb-3 fw-bold">My Comments</h2>
                            <table class="table table-stripped table-bordered table-hover">
                                <tr class="text-center">
                                    <th>Comment</th>
                                    <th>Published</th>
                                    <th>Article</th>
                                    <th>Operations</th>
                                </tr>
                                @forelse($comments as $comment)
                                    <tr class="dark:hover:bg-gray-600">
                                        <td class="text-center">{{ $comment->text }}</td>
                                        <td class="text-center">{{ $comment->created_at }}</td>
                                        <td class="text-center"><a
                                                href="{{ route('articles.show', $comment->article->id) }}">{{ $comment->article->headline }}</a>
                                        </td>
                                        <td class="text center">
                                            <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger mx-2">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Nothing to show</td>
                                    </tr>
                                @endforelse
                            </table>
                        @endif
                    </div>
                @endif


                {{-- Debug roles --}}
                {{-- @dd(Auth::user()->roles->pluck('role')->toArray()) --}}

                <!--WRITER'S DASHBOARD-->

                @if (Auth::user()->hasRole('writer'))
                    <div class="container col-12 card text-center table-responsive">
                        @if (!empty($articles))
                            <h2 class="text-center mt-3 mb-3 fw-bold">Published Articles</h2>
                            <table class="table table-stripped table-bordered table-hover align-middle">
                                <tr class="text-center">
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Headline</th>
                                    <th>Image</th>
                                    <th>Created</th>
                                    <th>Published</th>
                                    <th>Operations</th>
                                </tr>
                                @forelse($articles as $article)
                                    <tr>
                                        <td class="text-center">{{ $article->id }}</td>
                                        <td class="text-center">{{ $article->user->name }}</td>
                                        <td class="text-center"><a
                                                href="{{ route('articles.show', $article->id) }}">{{ $article->headline }}</a>
                                        </td>
                                        <td class="text-center" style="max-width: 80px">
                                            <div class="d-flex justify-content-center">
                                                <img class="rounded" style="max-width: 80%"
                                                    alt="image of {{ $article->headline }}"
                                                    title="image of {{ $article->headline }}"
                                                    src = "{{ $article->image
                                                        ? asset('storage/' . config('filesystems.articlesImageDir')) . '/' . $article->image
                                                        : asset('storage/' . config('filesystems.articlesImageDir')) . '/default.jpg' }}">
                                            </div>
                                        </td>
                                        <td class="text-center">{{ $article->created_at }}</td>
                                        <td class="text-center">{{ $article->published_at ?? 'Not published' }}</td>
                                        <td class="text-center">
                                            @if (Auth::user()->can('update', $article))
                                                <a class="mx-2" href="{{ route('articles.edit', $article->id) }}">
                                                    <button class="btn btn-dark">Edit</button></a>
                                            @endif

                                            @if (Auth::user()->can('delete', $article))
                                                <a class="mx-2" href="{{ route('articles.delete', $article->id) }}">
                                                    <button class="btn btn-danger">Delete</button></a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Nothing to show</td>
                                    </tr>
                                @endforelse
                            </table>
                        @endif


                        {{-- Rejected Articles --}}

                        @if (!empty($articlesrejected))
                            <div class="container col-12 card text-center table-responsive">
                                <h2 class="text-center mt-3 mb-3 fw-bold">Rejected Articles</h2>
                                <table class="table table-stripped table-bordered table-hover">
                                    <tr class="text-center">
                                        <th>Id</th>
                                        <th>Author</th>
                                        <th>Headline</th>
                                        <th>Image</th>
                                        <th>Created</th>
                                        <th>Published</th>
                                        <th>Operations</th>
                                    </tr>

                                    @forelse($articlesrejected as $article)
                                        <tr>
                                            <td class="text-center">{{ $article->id }}</td>
                                            <td class="text-center">{{ $article->user->name }}</td>
                                            <td class="text-center"><a
                                                    href="{{ route('articles.show', $article->id) }}">{{ $article->headline }}</a>
                                            </td>
                                            <td class="text-center" style="max-width: 80px">
                                                <div class="d-flex justify-content-center">
                                                    <img class="rounded" style="max-width: 80%"
                                                        alt="image of {{ $article->headline }}"
                                                        title="image of {{ $article->headline }}"
                                                        src = "{{ $article->image
                                                            ? asset('storage/' . config('filesystems.articlesImageDir')) . '/' . $article->image
                                                            : asset('storage/' . config('filesystems.articlesImageDir')) . '/default.jpg' }}">
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $article->created_at }}</td>
                                            <td class="text-center">{{ $article->published_at ?? 'Not published' }}
                                            </td>
                                            <td class="text-center">
                                                @if (Auth::user()->can('update', $article))
                                                    <a class="mx-2"
                                                        href="{{ route('articles.edit', $article->id) }}">
                                                        <button class="btn btn-dark">Edit</button></a>
                                                @endif

                                                @if (Auth::user()->can('delete', $article))
                                                    <a class="mx-2"
                                                        href="{{ route('articles.delete', $article->id) }}">
                                                        <button class="btn btn-danger">Delete</button></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Nothing to show</td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                        @endif

                        {{-- Drafts - Not published nor Rejected --}}
                        @if (!empty($drafts))
                            <div class="container col-12 card text-center table-responsive">
                                <h2 class="text-center mt-3 mb-3 fw-bold">Drafts</h2>
                                <table class="table table-stripped table-bordered">
                                    <tr class="text-center">
                                        <th>Id</th>
                                        <th>Author</th>
                                        <th>Headline</th>
                                        <th>Image</th>
                                        <th>Created</th>
                                        <th>Published</th>
                                        <th>Operations</th>
                                    </tr>
                                    @forelse($drafts as $article)
                                        <tr>
                                            <td class="text-center">{{ $article->id }}</td>
                                            <td class="text-center">{{ $article->user->name }}</td>
                                            <td class="text-center"><a
                                                    href="{{ route('articles.show', $article->id) }}">{{ $article->headline }}</a>
                                            </td>
                                            <td class="text-center" style="max-width: 80px">
                                                <div class="d-flex justify-content-center">
                                                    <img class="rounded" style="max-width: 80%"
                                                        alt="image of {{ $article->headline }}"
                                                        title="image of {{ $article->headline }}"
                                                        src = "{{ $article->image
                                                            ? asset('storage/' . config('filesystems.articlesImageDir')) . '/' . $article->image
                                                            : asset('storage/' . config('filesystems.articlesImageDir')) . '/default.jpg' }}">
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $article->created_at }}</td>
                                            <td class="text-center">{{ $article->published_at ?? 'Not published' }}
                                            </td>
                                            <td class="text-center">
                                                @if (Auth::user()->can('update', $article))
                                                    <a class="mx-2"
                                                        href="{{ route('articles.edit', $article->id) }}">
                                                        <button class="btn btn-dark">Edit</button></a>
                                                @endif

                                                @if (Auth::user()->can('delete', $article))
                                                    <a class="mx-2"
                                                        href="{{ route('articles.delete', $article->id) }}">
                                                        <button class="btn btn-danger">Delete</button></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Nothing to show</td>
                                        </tr>
                                    @endforelse
                                </table>
                            </div>
                        @endif
                    </div>
                @endif


                <!--EDITOR'S DASHBOARD-->

                @if (Auth::user()->hasRole('editor'))
                    <div class="card text-center">

                        @if (!empty($articlestoreview))
                        <div class="container col-12 card text-center table-responsive">
                            <h2 class="text-center mt-3 mb-3 fw-bold">Articles to Review</h2>
                            <table class="table table-stripped table-bordered table-hover">
                                <tr class="text-center">
                                    <th>Id</th>
                                    <th>Author</th>
                                    <th>Headline</th>
                                    <th>Image</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                    <th>Operations</th>
                                </tr>
                                @forelse($articlestoreview as $article)
                                    <tr>
                                        <td class="text-center">{{ $article->id }}</td>
                                        <td class="text-center">{{ $article->user->name }}</td>
                                        <td class="text-center"><a
                                                href="{{ route('articles.show', $article->id) }}">{{ $article->headline }}</a>
                                        </td>
                                        <td class="text-center" style="max-width: 80px">
                                            <div class="d-flex justify-content-center">
                                                <img class="rounded" style="max-width: 80%"
                                                    alt="image of {{ $article->headline }}"
                                                    title="image of {{ $article->headline }}"
                                                    src = "{{ $article->image
                                                        ? asset('storage/' . config('filesystems.articlesImageDir')) . '/' . $article->image
                                                        : asset('storage/' . config('filesystems.articlesImageDir')) . '/default.jpg' }}">
                                            </div>
                                        </td>
                                        @php
                                            if ($article->rejected == 0) {
                                                $status = 'New';
                                            } else {
                                                $status = 'Rejected';
                                            }
                                        @endphp
                                        <td class="text-center">{{ $article->created_at }}</td>
                                        <td class="text-center">{{ $status }}</td>
                                        <td class="text-center">
                                            @if (Auth::user()->can('update', $article))
                                                <a class="mx-2" href="{{ route('articles.edit', $article->id) }}">
                                                    <button class="btn btn-dark">Edit</button>
                                                </a>
                                            @endif

                                            @if (Auth::user()->can('delete', $article))
                                                <a class="mx-2"
                                                    href="{{ route('articles.delete', $article->id) }}">
                                                    <button class="btn btn-danger">Delete</button></a>
                                            @endif

                                            @if (Auth::user()->can('reject', $article) && $article->rejected == 0)
                                                <a class="mx-2"
                                                    href="{{ route('articles.reject', $article->id) }}">
                                                    <button class="btn btn-warning">Reject</button>
                                                </a>
                                            @endif

                                            @if (Auth::user()->can('publish', $article) && ($article->published_at == null || $article->rejected == 1))
                                                <a class="mx-2"
                                                    href="{{ route('articles.publish', $article->id) }}">
                                                    <button class="btn btn-success">Publish</button>
                                                </a>
                                            @endif
                                            @if (Auth::user()->can('maketopnews', $article) && ($article->published_at == null || $article->istopnews == 0))
                                                <a class="mx-2"
                                                    href="{{ route('articles.maketopnews', $article->id) }}">
                                                    <button class="btn btn-success">Top News</button>
                                                </a>
                                            @endif
                                            @if (Auth::user()->can('removetopnews', $article) && ($article->published_at == null && $article->istopnews == 1))
                                            <a class="mx-2"
                                                href="{{ route('articles.removetopnews', $article->id) }}">
                                                <button class="btn btn-danger">Remove Top News</button>
                                            </a>
                                        @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Nothing to show</td>
                                    </tr>
                                @endforelse
                            </table>
                        @endif
                    </div>
                @endif

                <!--ADMIN'S DASHBOARD-->
                @if (Auth::user()->hasRole('admin'))
                    <div class="container col-12 card text-center table-responsive">
                        @if (!empty($users))
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
                                        <td class="text-center">{{ $user->id }}</td>
                                        <td class="text-center">{{ $user->name }}</td>
                                        <td class="text-center"><a href="mailto:{{ $user->email }}">
                                                {{ $user->email }}</a></td>
                                        <td class="text-center">
                                            @foreach ($user->roles as $role)
                                                {{ $role->role }}
                                                <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center"><a class="text-decoration"
                                                href="{{ route('admin.users.show', $user->id) }}">Details</a></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Nothing to show</td>
                                    </tr>
                                @endforelse
                            </table>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
