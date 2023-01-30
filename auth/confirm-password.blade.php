<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                @isset($info)
                <img src="{{$info->website_logo}}" alt="" srcset="">
                @endisset
            </a>
        </x-slot>

        <div class="mb-4 text-md text-gray-600">
            {{ __('This is a secure area of website.
             Only authorized personell are allowed. Please confirm with your current
             password and the secret password of the website before continuing.') }}
        </div>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-label for="password" :value="__('Enter Your current Password Here')" />

                <x-input id="password" type="password"  name="password"
                class="block mt-1 w-full" required autocomplete="current-password" />
                    @error('password')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
            </div>

            <div>
                <x-label for="secret_password" :value="__('Enter the secret Password Here')" class="mt-5 w-full"/>

                <x-input id="secret_password" name="secret_password"  type="password"
                class="block mt-1 w-full"  required autocomplete="current-password" />
                    @error('secret_password')
                        <span class="text-red-600">{{ $message }}</span>
                    @enderror
            </div>
            <div class="flex justify-end mt-6">
                <x-button>
                    {{ __('Confirm') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
