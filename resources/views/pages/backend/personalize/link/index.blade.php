<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Links') }}
            </h2>
            <a href="{{ route('links.create') }}" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                Tambah Link
            </a>
        </div>
    </x-slot>

    <div class="">
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">No</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Icon</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Platform</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama Akun</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Link</th>
                        <th class="px-4 py-2 text-sm font-medium text-gray-700 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-600">
                    @foreach ($link as $index => $l)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">
                                <i class="{{ $l->icon }} dynamic-icon" data-fallback="fa-solid fa-circle-xmark"
                                    title="{{ $l->icon }}"></i>
                            </td>
                            <td class="px-4 py-2">{{ $l->title }}</td>
                            <td class="px-4 py-2">{{ $l->account }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ $l->url }}" target="_blank" class="text-blue-500 hover:underline">
                                    {{ $l->url }}
                                </a>
                            </td>
                            <td class=" px-4 py-2 flex items-center justify-center gap-2">
                                <a href="{{ route('links.edit', $l) }}"
                                    class="inline-block text-blue-500 hover:text-blue-600 mr-2">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('links.destroy', $l) }}" method="POST" class="inline"
                                    onsubmit="return confirm('Yakin ingin menghapus link ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-600">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
