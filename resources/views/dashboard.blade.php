<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    You're logged in!
                    <span>
                        <a href="/dashboard/user/edit/read" class="ml-5 card-link inline-block text-green-400"> Edit user details </a>
                    </span>
                    <span>
                    <form action="/dashboard/user/edit/delete" method="POST" class="inline-block">
                    @csrf    
                    @method('DELETE')
                    <span>
                        <button class="text-red-500 ml-5" type="submit">Terminate account</button>
                    </span>
                </form>  
                    </span>
                </div>
            </div>
        </div>
    </div>

    @isset($posts)
    <div class="grid grid-cols-1 md:gap-3 md:grid-cols-4 mx-8">
        @foreach ($posts as $post)

        <div class="card" style="width: 18rem;">
            <div class="shadow-md h-32 w-32 font-medium bg-white rounded-md sm:w-auto sm:h-auto pading p-4">
                <h5 class="card-title block text-center font-normal md:font-bold mb-2">{{$post->title}}</h5>
                <h6 class="card-subtitle mb-2 text-muted block text-gray-500 text-sm">Last updated on,
                    {{$post->updated_at->toString()}} </h6>
                <p class="card-text overflow-ellipsis truncate block"> {{strip_tags($post->body)}}</p>
                <div class="flex justify-center mt-2">
                <a href="/user/posts/{{$post->id}}/edit" class="card-link inline-block text-green-400">Edit post</a>
                <form action="/user/posts/{{$post->id}}/delete" method="POST">
                    @csrf    
                    @method('DELETE')
                    <button class="card-link inline-block text-red-500 ml-5" type="submit">Delete post</button>
                </form>        
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endisset


    @if(count($posts) == 0)
    <h1 class="font-mono md:font-sans text-base md:text-lg text-center"> No posts to show! Add some to display</h1>
    @endif


    <!-- Pin to bottom right corner -->
    <div class="relative h-32 w-32">
        <button
            onclick="window.location.href='/user/posts/post/create';"
            class="absolute bottom-0 right-0 bg-indigo-500 hover:bg-indigo-700 h-16 w-16 text-white text-center font-extrabold flex items-center justify-center rounded-full">
            Add</button>
    </div>
</x-app-layout>