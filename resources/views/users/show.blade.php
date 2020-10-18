<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 px-4 lg:px-8">
        <div class="text-3xl">{{ $user->name }}</div>

        <div class="flex space-x-2">
            <div>🏆 {{ $user->games()->count() }} {{ \Illuminate\Support\Str::plural('game', $user->games()->count()) }} won</div>

            <div>☠️ {{ $user->games()->count() }} {{ \Illuminate\Support\Str::plural('game', $user->games()->count()) }} lost</div>
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
