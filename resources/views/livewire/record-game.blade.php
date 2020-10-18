<div>
    <div class="mb-2 flex space-x-4">
        <div class="flex-1">
            <label class="block text-sm leading-5 font-medium text-gray-700">Player 1</label>
            <select wire:model="player1" class="@error('player1') {{ $message }} border-red-500 @enderror mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                <option value="null" selected disabled>Please select&hellip;</option>
                @foreach($teammates as $teammate)
                    <option value="{{ $teammate->getKey() }}" @if($teammate == auth()->user()) selected @endif>{{ $teammate->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex-1">
            <label class="block text-sm leading-5 font-medium text-gray-700">Player 2</label>
            <select wire:model="player2" class="@error('player2') border-red-500 @enderror mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                <option value="null" selected disabled>Please select&hellip;</option>
                @foreach($teammates as $teammate)
                    <option value="{{ $teammate->getKey() }}">{{ $teammate->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mb-4 flex space-x-4">
        <div class="flex-1">
            <div class="mt-1 relative rounded-md shadow-sm">
                <input wire:model="player1Score" type="number" class="@error('player1Score') border-red-500 @enderror form-input block w-full sm:text-sm sm:leading-5" placeholder="Score">
            </div>
        </div>

        <div class="flex-1">
            <div class="mt-1 relative rounded-md shadow-sm">
                <input wire:model="player2Score" type="number" class="@error('player2Score') border-red-500 @enderror form-input block w-full sm:text-sm sm:leading-5" placeholder="Score">
            </div>
        </div>
    </div>

    <div class="mb-4 flex-1">
        <label class="block text-sm leading-5 font-medium text-gray-700">Winner</label>
        <select wire:model="winner" class="@error('winner') border-red-500 @enderror mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
            <option value="null" selected disabled>Please select&hellip;</option>
            @foreach($this->players as $teammate)
                <option value="{{ $teammate->getKey() }}">{{ $teammate->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="text-right">
        <span class="inline-flex rounded-md shadow-sm">
            <button wire:click="submit" type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                Record Game
            </button>
        </span>
    </div>
</div>
