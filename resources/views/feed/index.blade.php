<x-layouts.app>
    <x-slot name="header">
        Feed
    </x-slot>   
    <div class="mt-8 space-y-6">
        @foreach($books as $book)
            <div class="space-y-3">
                <div>{{ $book->user->first()->name }} {{ $book->book_user->action }} {{ $book->title }}</div>
                <x-book :book="$book"/>
            </div>
        @endforeach
    </div>
</x-layouts.app>