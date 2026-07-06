<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Mobil') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('cars.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
                                <input type="text" id="name" name="name" class="mt-1 block w-full" required>
                            </div>

                            <div>
                                <div class="flex justify-between items-center">
                                    <label for="car_category_id"
                                        class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <a href="{{ route('car-categories.index') }}"
                                        class="hover:underline cursor-pointer">+ Kategori</a>
                                </div>
                                <select id="car_category_id" name="car_category_id" class="mt-1 block w-full" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="plate_number" class="block text-sm font-medium text-gray-700">Nomor
                                    Plat</label>
                                <input type="text" id="plate_number" name="plate_number" class="mt-1 block w-full"
                                    required>
                            </div>

                            <div>
                                <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                                <input type="number" id="year" name="year" class="mt-1 block w-full" required>
                            </div>

                            <div>
                                <label for="seats" class="block text-sm font-medium text-gray-700">Jumlah
                                    Kursi</label>
                                <input type="number" id="seats" name="seats" class="mt-1 block w-full" required>
                            </div>

                            <div>
                                <label for="transmission"
                                    class="block text-sm font-medium text-gray-700">Transmisi</label>
                                <select id="transmission" name="transmission" class="mt-1 block w-full" required>
                                    <option value="manual">Manual</option>
                                    <option value="automatic">Automatic</option>
                                </select>
                            </div>

                            <div>
                                <label for="color" class="block text-sm font-medium text-gray-700">Warna</label>
                                <input type="text" id="color" name="color" class="mt-1 block w-full" required>
                            </div>

                            <div>
                                <label for="price_per_12_hours" class="block text-sm font-medium text-gray-700">Harga
                                    Sewa per 12 Jam</label>
                                <input type="number" id="price_per_12_hours" name="price_per_12_hours"
                                    class="mt-1 block w-full" step="0.01">
                            </div>

                            <div>
                                <label for="price_per_day" class="block text-sm font-medium text-gray-700">Harga Sewa
                                    per Hari</label>
                                <input type="number" id="price_per_day" name="price_per_day" class="mt-1 block w-full"
                                    step="0.01" required>
                            </div>

                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700">Foto Mobil</label>
                                <input type="file" name="photo[]" id="photo" multiple class="mt-1 block w-full">
                            </div>

                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea id="description" name="description" class="mt-1 block w-full"></textarea>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">
                                Simpan Mobil
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
