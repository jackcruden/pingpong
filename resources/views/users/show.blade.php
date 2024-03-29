<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 lg:px-8">
        <div class="flex mb-2 space-x-2">
            <img src="{{ $user->profile_photo_url }}" class="block rounded-full" width="70" height="70">

            <duv>
                <div class="text-3xl">{{ $user->name }}</div>

                <div class="flex space-x-2">
                    <div>🏆 {{ $user->wins()->count() }} {{ \Illuminate\Support\Str::plural('game', $user->wins()->count()) }} won</div>

                    <div>☠️ {{ $user->losses()->count() }} {{ \Illuminate\Support\Str::plural('game', $user->losses()->count()) }} lost</div>
                </div>
            </duv>
        </div>

        <div class="my-5">
            <div class="flex font-bold">
                <div class="flex-1">Recent games</div>

                <div>Winner</div>
            </div>

            <ul>
                @foreach($user->games()->take(5)->get() as $game)
                    <livewire:game :game="$game" />
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
