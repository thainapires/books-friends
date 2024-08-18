<x-layouts.app>
    <x-slot name="header">
        Friends
    </x-slot>
    <div class="space-y-6">

        @if($friends->count())
            <div>
                <h1 class="font-bold text-xl text-slate-600">Friends</h1>
                <div class="mt-4 space-y-3">
                    @foreach($friends as $friend)
                        <div>
                            {{ $friend->name }}
                        </div>
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
                            {{ $pendingFriend->name }}
                        </div>
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
                            {{ $friendRequest->name }}
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>