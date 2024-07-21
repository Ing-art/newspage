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
                @if(!empty($comments))
                <p>Here the user's comments</p> <!--TODO-->
                @endif
                
                @if(!empty($articles))
                <table class="table table-stripped table-bordered">
                    <tr class="text-center">
                        <th>Id</th>
                        <th>Author</th>
                        <th>Headline</th>
                        <th>Image</th>
                        <th>Created</th>
                        <th>Published</th>
                        <th>Rejected</th>
                        <th>Operations</th>
                    </tr>
                    @foreach($articles as $article)
                    <tr>
                        <td class="text-center">{{$article->id}}</td>
                        <td class="text-center">{{$article->user->name}}</td>
                        <td class="text-center">{{$article->headline}}</td>
                        <td class="text-center" style="max-width: 80px">
                            <img class="rounded" style="max-width: 80%"
                                alt="image of {{$article->headline}}"
                                title="image of {{$article->headline}}"
                                src = "{{
                                $article->image? asset('storage/'.config('filesystems.articlesImageDir')).'/'.$article->image :
                            asset('storage/'.config('filesystems.articlesImageDir')).'/default.jpg'}}">
                        </td>
                        <td class="text-center">{{$article->created_at}}</td>
                        <td class="text-center">{{$article->published_at ?? 'Not published'}}</td>
                        <td class="text-center">{{$article->rejected ? 'Yes' : ''}}</td>
                        <td class="text-center">Operations</td>
                    </tr> 
                    @endforeach           
                </table>
                @endif       
            </div>
        </div>
    </div>   
</x-app-layout>
