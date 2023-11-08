<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('If you have forgotten your password, do not worry! Just provide your email address and we will send you a password reset link. No need to stress, we have got you covered.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Send Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
