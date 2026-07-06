<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-xl font-semibold text-gray-800 leading-tight">
                {{ __('Tambah Link') }}
            </h2>
        </div>
    </x-slot>

    <div class="p-4">
        <form action="{{ route('links.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6 max-w-xl mx-auto bg-white p-6 rounded shadow">
            @csrf

            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700">Icon</label>
                <input type="text" name="icon" id="icon"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Icon dari Fontawesome" required>
            </div>

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700">Nama Platform</label>
                <input type="text" name="title" id="title"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Masukkan Nama Platform" required>
            </div>

            <div>
                <label for="account_name" class="block text-sm font-medium text-gray-700">Nama Akun</label>
                <input type="text" name="account_name" id="account_name"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="Masukkan Nama Akun" required>
            </div>

            <div>
                <label for="link" class="block text-sm font-medium text-gray-700">Link</label>
                <input type="url" name="link" id="link"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-red-500 focus:border-red-500"
                    placeholder="https://example.com/username" required>
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
