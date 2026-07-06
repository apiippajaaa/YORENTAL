<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800">
                {{ __('Daftar Mobil') }}
            </h2>

            <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto max-w-lg">
                <form method="GET" action="{{ route('cars.index') }}" class="flex w-full gap-2">
                    <input type="text" name="search" value="{{ request()->search }}" placeholder="Cari mobil..."
                        class="w-full sm:w-64 border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 whitespace-nowrap">
                        Cari
                    </button>
                </form>

                <a href="{{ route('cars.create') }}"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg text-center hover:bg-green-600 whitespace-nowrap">
                    Tambah Mobil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg mt-4 p-4">
        {{-- Desktop Table --}}
        <div class="hidden md:block overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">No</th>
                        <th class="px-4 py-2 text-left">Nama Mobil</th>
                        <th class="px-4 py-2 text-left">Kategori</th>
                        <th class="px-4 py-2 text-left">Foto</th>
                        <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cars as $index => $car)
                        <tr class="border-b">
                            <td class="px-4 py-2">{{ $cars->firstItem() + $index }}</td>
                            <td class="px-4 py-2">{{ $car->name }}</td>
                            <td class="px-4 py-2">{{ $car->category->name ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @if ($car->photos->first())
                                    <img src="{{ asset('storage/' . $car->photos->first()->photo_path) }}"
                                        alt="Foto Mobil" class="w-16 h-10 object-cover rounded">
                                @else
                                    <span class="text-gray-400 text-sm">Tidak ada foto</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 flex gap-3">
                                {{-- <a href="{{ route('cars.show', $car) }}" class="text-green-600 hover:text-green-800"
                                    title="Lihat">
                                    <i class="fa-solid fa-eye"></i>
                                </a> --}}

                                <a href="{{ route('cars.edit', $car) }}" class="text-blue-600 hover:text-blue-800"
                                    title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('cars.destroy', $car) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus mobil ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- Pagination Desktop --}}
            <div class="mt-4">
                {{ $cars->links() }}
            </div>
        </div>

        {{-- Mobile Card View --}}
        <div class="md:hidden flex flex-col gap-4">
            @foreach ($cars as $car)
                <div class="border rounded-lg p-4 shadow-sm">
                    <div class="flex gap-4 items-center">
                        <div class="w-24 h-16 rounded overflow-hidden bg-gray-100">
                            @if ($car->photos->first())
                                <img src="{{ asset('storage/' . $car->photos->first()->photo_path) }}" alt="Foto Mobil"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-sm text-gray-400">Tidak
                                    ada foto</div>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold">{{ $car->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $car->category->name ?? '-' }}</p>
                        </div>
                    </div>
                    <td>
                        <div class="flex gap-4 mt-3">
                            <a href="{{ route('cars.show', $car) }}" class="text-green-600 hover:text-green-800"
                                title="Lihat">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('cars.edit', $car) }}" class="text-blue-600 hover:text-blue-800 "
                                title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>

                            </a>


                            <form action="{{ route('cars.destroy', $car) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus mobil ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </div>
            @endforeach

            {{-- Pagination Mobile --}}
            <div class="mt-4">
                {{ $cars->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
