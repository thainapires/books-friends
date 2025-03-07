<x-layouts.app>
    <x-slot name="header">
        Edit book
    </x-slot>
    <form action="/books/{{$book->id}}" method="post" class="mt-4 space-y-4">
        @csrf
        @method('PUT')
        <div class="space-y-1">
            <label for="title" class="block">Title</label>
            <input type="text" name="title" id="title" class="rounded block w-full border-2	border-gray-300" value="{{ old('title') ?: $book->title }}">
            @error('title')
                <div class="text-red-500 text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="author" class="block">Author</label>
            <input type="text" name="author" id="author" class="rounded block w-full border-2 border-gray-300" value="{{ old('author') ?: $book->author }}">
            @error('author')
                <div class="text-red-500 text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="space-y-1">
            <label for="status" class="block">Status</label>
            <select name="status" id="status" class="rounded block w-full border-2 border-gray-300">
                @foreach(\App\Models\Pivot\BookUser::$statuses as $key => $status)
                    <option value="{{$key}}"{{ $book->pivot->status === $key ? ' selected' : ''}}>{{$status}}</option>
                @endforeach
            </select>
            @error('status')
                <div class="text-red-500 text-sm">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button type="submit" class="bg-slate-200 px-3 py-2 rounded">
            Edit book
        </button>
    </form>
    
</x-layouts.app>