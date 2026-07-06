<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Edit Link') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-4">
        <form action="{{ route('links.update', $link) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 max-w-xl mx-auto bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')

            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
                <input type="text" name="icon" id="icon" value="{{ old('icon', $link->icon) }}"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500"
                    required>
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Nama Platform</label>
                <input type="text" name="title" id="title" value="{{ old('title', $link->title) }}"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500"
                    required>
            </div>

            <div>
                <label for="account" class="block text-sm font-medium text-gray-700">Nama Akun</label>
                <input type="text" name="account" id="account" value="{{ old('account', $link->account) }}"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500"
                    required>
            </div>

            <div>
                <label for="url" class="block text-sm font-medium text-gray-700">URL</label>
                <input type="url" name="url" id="url" value="{{ old('url', $link->url) }}"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500"
                    required>
            </div>

            <div class=" flex justify-end gap-2">
                <a href="{{ route('links.index') }}"
                    class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                    ← Kembali
                </a>
                <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-md hover:bg-red-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
