<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-4 text-center">
                <a href="{{ route('login.social', ['provider' => 'github']) }}" class="block p-2 font-medium border rounded-lg">
                    Sign in with GitHub
                </a>

                <a href="{{ route('login.social', ['provider' => 'google']) }}" class="block p-2 font-medium border rounded-lg">
                    Sign in with Google
                </a>
            </div>
        </form>
    </x-jet-authentication-card>
</x-guest-layout>
