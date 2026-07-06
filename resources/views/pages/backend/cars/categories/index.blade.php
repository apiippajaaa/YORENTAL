<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="text-2xl font-semibold text-gray-800">
                {{ __('Kategori Mobil') }}
            </h2>
            <a href="{{ route('car-categories.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Kategori
            </a>
        </div>
    </x-slot>

    <div class="p-4">
        <div class="bg-white shadow rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-gray-700">
                    <thead class="bg-red-500 text-white">
                        <tr>
                            <th class="px-4 py-3 text-center w-16">No</th>
                            <th class="px-4 py-3 text-left">Kategori</th>
                            <th class="px-4 py-3 text-center w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $index => $category)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="text-center px-4 py-3">{{ $index + 1 }}</td>
                                <td class="px-4 py-3">{{ $category->name }}</td>
                                <td class="text-center px-4 py-3">
                                    <div class="flex justify-center gap-2">
                                        <a href="{{ route('car-categories.edit', $category->id) }}"
                                            class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-md"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path
                                                    d="M17.414 2.586a2 2 0 010 2.828l-9.086 9.086a1 1 0 01-.293.207l-4 2a1 1 0 01-1.32-1.32l2-4a1 1 0 01.207-.293l9.086-9.086a2 2 0 012.828 0z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('car-categories.destroy', $category->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kategori {{ $category->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-md"
                                                title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M6 3a1 1 0 000 2h8a1 1 0 100-2H6zM5 6a1 1 0 011-1h8a1 1 0 011 1v10a2 2 0 01-2 2H7a2 2 0 01-2-2V6zm3 2a1 1 0 112 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 112 0v6a1 1 0 11-2 0V8z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center px-4 py-6 text-gray-500">
                                    Belum ada kategori tersedia.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
