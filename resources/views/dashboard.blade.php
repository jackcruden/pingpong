<x-app-layout>
    <div class="bg-white py-6 px-4 border-b border-gray-200">
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

            <ul class="flex space-x-4">
                @foreach(auth()->user()->currentTeam->allUsers()->orderByRate()->get() as $position => $user)
                    <x-user :user="$user" :position="$position" />
                @endforeach
            </ul>
        </div>

        <div class="mb-5">
            <div class="flex font-bold">
                <div class="flex-1">Recently played</div>

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
