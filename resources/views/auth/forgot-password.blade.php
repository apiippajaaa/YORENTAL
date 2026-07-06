<x-auth-layout>
    <div class="w-full max-w-sm bg-white shadow-lg rounded-lg p-8 mx-auto">
        <h2 class="text-2xl font-semibold text-center mb-6">Reset Password</h2>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Lupa password? jangan khawatir, masukin aja emailmu di bawah ini, jika kedaftar sebagai user, kami akan mengirimkan link reset password.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-6">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
                    class="block mt-1 w-full border border-gray-300 rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500"
                    type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end mt-4">
                <x-primary-button
                    class="w-full bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-auth-layout>
