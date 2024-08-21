<x-layouts.app>
    <x-slot name="header">
        Friends
    </x-slot>
    <div class="space-y-6">
        <div>
            <h1 class="font-bold text-xl text-slate-600">Add a friend</h1>
            <form action="/friends" method="post" class="mt-4 space-y-4">
                @csrf
                <div class="space-y-1">
                    <label for="email" class="block">Email address</label>
                    <input type="email" name="email" id="email" placeholder="e.g. you@somewhere.com" class="rounded block w-full border-2 border-gray-300">
                    @error('email')
                        <div class="text-sm text-red-500 mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="bg-slate-200 px-3 py-2 rounded">
                    Send request
                </button>
            </form>
        </div>

        @if($friends->count())
            <div>
                <h1 class="font-bold text-xl text-slate-600">Friends</h1>
                <div class="mt-4 space-y-3">
                    @foreach($friends as $friend)
                        <div>
                            {{ $friend->name }} ({{ $friend->email }})
                        </div>

                        <form action="/friends/{{ $friend->id }}" method="post" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-blue-500">Remove</button>
                        </form>
                    @endforeach
                </div>
            </div>
        @endif

        @if($pendingFriends->count())
            <div>
                <h1 class="font-bold text-xl text-slate-600">Pending friend requests</h1>
                <div class="mt-4 space-y-3">
                    @foreach($pendingFriends as $pendingFriend)
                        <div>
                            {{ $pendingFriend->name }} ({{ $pendingFriend->email }})
                        </div>
                        <form action="/friends/{{ $pendingFriend->id }}" method="post" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="text-blue-500">Cancel</button>
                        </form>
                    @endforeach
                </div>
            </div>
        @endif

        @if($friendRequests->count())
            <div>
                <h1 class="font-bold text-xl text-slate-600">Friend requests</h1>
                <div class="mt-4 space-y-3">
                    @foreach($friendRequests as $friendRequest)
                        <div>
                            {{ $friendRequest->name }} ({{ $friendRequest->email }})

                            <form action="/friends/{{$friendRequest->id}}" method="post" class="inline">
                                @csrf
                                @method('PATCH')
                                <button class="text-blue-500">Accept</button>

                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>