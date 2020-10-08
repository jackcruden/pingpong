<x-app-layout>
    <div class="bg-white py-6 px-4 border-b border-gray-200">
        <div class="flex justify-between">
            <h1 class="text-4xl font-black">Record Game</h1>
        </div>


        <div class="mb-2 flex space-x-4">
            <div class="flex-1">
                <label for="player-1" class="block text-sm leading-5 font-medium text-gray-700">Player 1</label>
                <select id="player-1"
                        class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    @foreach(auth()->user()->currentTeam->users as $user)
                        <option value="{{ $user->getKey() }}" @if($user == auth()->user()) selected @endif>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1">
                <label for="player-2" class="block text-sm leading-5 font-medium text-gray-700">Player 2</label>
                <select id="player-2"
                        class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                    <option selected disabled>Please select...</option>
                    @foreach(auth()->user()->currentTeam->users as $user)
                        <option value="{{ $user->getKey() }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mb-4 flex space-x-4">
            <div class="flex-1">
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="email" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="Score">
                </div>
            </div>

            <div class="flex-1">
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input id="email" class="form-input block w-full sm:text-sm sm:leading-5" placeholder="Score">
                </div>
            </div>
        </div>

        <div class="mb-4 flex-1">
            <label for="player-1" class="block text-sm leading-5 font-medium text-gray-700">Winner</label>
            <select id="player-1"
                    class="mt-1 form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-gray-300 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5">
                @foreach(auth()->user()->currentTeam->users as $user)
                    <option value="{{ $user->getKey() }}" @if($user == auth()->user()) selected @endif>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="text-right">
            <span class="inline-flex rounded-md shadow-sm">
                <button type="button" class="inline-flex items-center px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition ease-in-out duration-150">
                    Record Game
                </button>
            </span>
        </div>
    </div>
</x-app-layout>
