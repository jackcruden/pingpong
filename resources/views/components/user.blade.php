<div>
    <a href="{{ route('users.show', $user) }}" class="block p-2 border border-gray-100 shadow rounded-lg">
        <div class="w-20 h-20 mx-auto">
            <img src="{{ $user->profile_photo_url }}" width="70" height="70" class="rounded-full mx-auto">
            <div class="relative text-3xl -mt-6 -ml-1">{{ $position }}</div>
        </div>

        <div class="text-center">
            <div class="font-bold">{{ $user->name }}</div>
            <div>{{ $user->rate }}%</div>
            <div class="text-xs">🏆{{ $user->wins()->count() }} ☠️{{ $user->losses()->count() }}</div>
        </div>
    </a>
</div>
