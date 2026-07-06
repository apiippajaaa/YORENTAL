<x-app-layout>
    <div class="container space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold">Edit Mobil</h1>
            <a href="{{ route('cars.index') }}" class="text-blue-600 hover:underline">← Kembali</a>
        </div>

        <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data"
            class="bg-white p-2 md:p-6 rounded-xl shadow space-y-4">
            @csrf
            @method('PUT')

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full" required
                                value="{{ old('name', $car->name ?? '') }}">
                        </div>

                        <div>
                            <div class="flex justify-between items-center">
                                <label for="car_category_id"
                                    class="block text-sm font-medium text-gray-700">Kategori</label>
                                <a href="{{ route('car-categories.index') }}" class="hover:underline cursor-pointer">+
                                    Kategori</a>
                            </div>
                            <select id="car_category_id" name="car_category_id" class="mt-1 block w-full" required>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('car_category_id', $car->car_category_id ?? '') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="plate_number" class="block text-sm font-medium text-gray-700">Nomor Plat</label>
                            <input type="text" id="plate_number" name="plate_number" class="mt-1 block w-full"
                                required value="{{ old('plate_number', $car->plate_number ?? '') }}">
                        </div>

                        <div>
                            <label for="year" class="block text-sm font-medium text-gray-700">Tahun</label>
                            <input type="number" id="year" name="year" class="mt-1 block w-full" required
                                value="{{ old('year', $car->year ?? '') }}">
                        </div>

                        <div>
                            <label for="seats" class="block text-sm font-medium text-gray-700">Jumlah Kursi</label>
                            <input type="number" id="seats" name="seats" class="mt-1 block w-full" required
                                value="{{ old('seats', $car->seats ?? '') }}">
                        </div>

                        <div>
                            <label for="transmission" class="block text-sm font-medium text-gray-700">Transmisi</label>
                            <select id="transmission" name="transmission" class="mt-1 block w-full" required>
                                <option value="manual"
                                    {{ old('transmission', $car->transmission ?? '') == 'manual' ? 'selected' : '' }}>
                                    Manual</option>
                                <option value="automatic"
                                    {{ old('transmission', $car->transmission ?? '') == 'automatic' ? 'selected' : '' }}>
                                    Automatic
                                </option>
                            </select>
                        </div>

                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">Warna</label>
                            <input type="text" id="color" name="color" class="mt-1 block w-full" required
                                value="{{ old('color', $car->color ?? '') }}">
                        </div>

                        <div>
                            <label for="price_per_12_hours" class="block text-sm font-medium text-gray-700">Harga Sewa
                                per 12 Jam</label>
                            <input type="number" id="price_per_12_hours" name="price_per_12_hours"
                                class="mt-1 block w-full" step="0.01"
                                value="{{ old('price_per_12_hours', $car->price_per_12_hours ?? '') }}">
                        </div>

                        <div>
                            <label for="price_per_day" class="block text-sm font-medium text-gray-700">Harga Sewa per
                                Hari</label>
                            <input type="number" id="price_per_day" name="price_per_day" class="mt-1 block w-full"
                                step="0.01" required value="{{ old('price_per_day', $car->price_per_day ?? '') }}">
                        </div>

                        <div>
                            <label for="photo" class="block text-sm font-medium text-gray-700">Foto Mobil</label>
                            <input type="file" name="photo[]" id="photo" multiple class="mt-1 block w-full">
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea id="description" name="description" class="mt-1 block w-full">{{ old('description', $car->description ?? '') }}</textarea>
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

        {{-- Manajemen Foto --}}
        <div class="bg-white p-4 sm:p-6 rounded-xl shadow space-y-4">
            <h2 class="text-lg sm:text-xl font-semibold">Foto Mobil</h2>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($car->photos as $photo)
                    <div class="border rounded p-2 space-y-2 flex flex-col items-center">
                        <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Foto Mobil"
                            class="w-28 h-20 object-cover rounded">

                        {{-- Form Update Foto --}}
                        <form action="{{ route('cars.photos.update', [$car->id, $photo->id]) }}" method="POST"
                            enctype="multipart/form-data" class="w-full">
                            @csrf
                            @method('PUT')
                            <input type="file" name="photo" accept="image/*" class="w-full text-xs mb-1"
                                required>
                            <button type="submit"
                                class="w-full bg-green-600 text-white text-xs px-2 py-1 rounded hover:bg-green-700">
                                Ganti Foto
                            </button>
                        </form>

                        {{-- Form Hapus Foto --}}
                        <form action="{{ route('cars.photos.destroy', [$car->id, $photo->id]) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus foto ini?')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full bg-red-600 text-white text-xs px-2 py-1 rounded hover:bg-red-700">
                                Hapus
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
