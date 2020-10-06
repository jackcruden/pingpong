<div class="flex py-2 border-b">
    <div class="flex-1">
        <div>🏓 {{ $game->title }}</div>
        @if($game->hasScores())
            <div class="text-xs text-gray-500">{{ $game->scores }}</div>
        @endif
    </div>

    <div class="text-right">
        <div>🏆 {{ $game->winner->name }}</div>
        <div class="text-xs text-gray-500">{{ $game->created_at->ago() }}</div>
    </div>
</div>
