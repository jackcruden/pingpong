<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 lg:px-8">
        <div class="flex justify-between">
            <div>
                <h1 class="text-4xl font-black">Hi, {{ auth()->user()->name }}!</h1>
            </div>

            <a href="{{ route('games.create') }}" class="block px-4 rounded-lg bg-black text-4xl font-black text-white">&plus;</a>
        </div>

        <div class="mb-5">
            <div class="flex font-bold">
                <div class="flex-1 text-lg">Leaderboard</div>
            </div>

            <div class="-mx-4">
                <ul class="flex space-x-4 py-2 px-4 max-w-full overflow-x-scroll">
                    @foreach(auth()->user()->currentTeam->allUsers()->sortByDesc(fn ($user) => $user->rate)->values() as $position => $user)
                        <x-user :user="$user" :position="$position" />
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="mb-5">
            <div class="flex font-bold">
                <div class="flex-1">Recent games</div>

                <div>Winner</div>
            </div>

            <ul>
                @foreach(auth()->user()->currentTeam->games()->take(5)->get() as $game)
                    <livewire:game :game="$game" />
                @endforeach
            </ul>
        </div>
    </div>
</x-app-layout>
