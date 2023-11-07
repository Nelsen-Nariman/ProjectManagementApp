<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Before we proceed, could you kindly verify your email address by clicking on the link that was sent to you via email? This will help ensure the security of your account and prevent any unauthorized access. Thank you for your understanding!') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Link has been sent') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend link') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ __('Log out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
