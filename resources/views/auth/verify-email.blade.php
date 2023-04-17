<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                @isset($info)
                <img src="{{$info->website_logo}}" alt="" srcset="">
                @endisset
            </a>
        </x-slot>

        <div class="mb-4 text-lg  font-bold text-gray-600">
            {{ __('Thanks for signing up! Before getting started,you should verify your email address . If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-md text-green-600">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-8 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Resend Verification Email') }}
                    </x-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="bg-green-600 px-4 py-2 text-sm text-white font-bold rounded-md
                 uppercase hover:text-yellow-300   ">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
