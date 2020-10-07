<div>
    <div class="p-2 border border-gray-100 shadow rounded-lg">
        <img src="{{ auth()->user()->profile_photo_url }}" width="70" height="70" class="rounded-full mx-auto">
        <div class="relative text-3xl -mt-6 -ml-1">{{ $position }}</div>

        <div class="font-bold">{{ $user->name }}</div>
        <div class="text-xs">🏆{{ $user->wins()->count() }} ☠️{{ $user->losses()->count() }}</div>
    </div>
</div>
