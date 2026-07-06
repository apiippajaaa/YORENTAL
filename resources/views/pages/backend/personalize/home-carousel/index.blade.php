<x-app-layout>
    <x-slot name="header">
        <div x-data="{ showAddModal: false }" class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Home Carousel') }}
            </h2>

            <!-- Tombol untuk membuka modal Tambah Gambar -->
            <button @click="showAddModal = true" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Tambah Carousel
            </button>

            <!-- Modal Tambah Gambar -->
            <div x-show="showAddModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
                <div class="bg-white rounded-xl shadow-lg p-6 w-96">
                    <h3 class="text-lg font-bold mb-4">Tambah Gambar Carousel</h3>

                    <form action="{{ route('home-carousel.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700">Pilih Gambar</label>
                            <input type="file" name="image" required
                                class="mt-1 w-full px-3 py-2 border rounded-md">
                        </div>

                        <div class="flex justify-end gap-2">
                            <button type="button" @click="showAddModal = false"
                                class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <div x-data="{
        showViewModal: false,
        viewImage: '',
    
        showEditModal: false,
        editId: null,
        editImage: '',
        editUrl: '',
    
        showDeleteModal: false,
        deleteUrl: '',
        selectedName: '',
    }" class="py-6 px-4">

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach ($homecarousels as $carousel)
                <div
                    class="w-full border p-2 rounded shadow flex flex-col items-center bg-white hover:scale-105 transition-all ease-in-out duration-300">
                    <div class="p-2">
                        <img src="{{ asset('storage/' . $carousel->image) }}" width="300" class="mb-2 rounded-md">
                    </div>
                    <div class="flex gap-2">
                        <!-- Tombol View -->
                        <button @click="showViewModal = true; viewImage = '{{ asset('storage/' . $carousel->image) }}';"
                            class="btn btn-info text-blue-600 hover:text-blue-800 transition duration-200">
                            <i class="fa-solid fa-eye"></i>
                        </button>

                        <!-- Tombol Edit -->
                        {{-- <a href="{{ route('home-carousel.edit', $carousel) }}"
                            class="btn btn-success text-green-600 hover:text-green-800 transition duration-200">
                            <i class="fa-solid fa-pen"></i>
                        </a> --}}
                        <!-- Tombol Edit -->
                        <button
                            @click="
        showEditModal = true;
        editId = {{ $carousel->id }};
        editImage = '{{ asset('storage/' . $carousel->image) }}';
    "
                            class="btn btn-success text-green-600 hover:text-green-800 transition duration-200">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>

                        <!-- Tombol Hapus -->
                        <button
                            @click="showDeleteModal = true; deleteUrl = '{{ route('home-carousel.destroy', $carousel) }}'; selectedName = 'Gambar ID: {{ $carousel->id }}';"
                            class="btn btn-error text-red-600 hover:text-red-800 transition duration-200">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Modal View Gambar -->
        <div x-show="showViewModal" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm">
            <div class="bg-white p-4 rounded-lg shadow-lg w-auto max-w-3xl">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Lihat Gambar</h3>
                    <button @click="showViewModal = false" class="text-red-500 hover:text-red-700">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>
                <img :src="viewImage" alt="Preview" class="w-full rounded-lg">
            </div>
        </div>

        <!-- Modal Edit Gambar -->
        <div x-show="showEditModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white rounded-xl shadow-lg p-6 w-96">
                <h3 class="text-lg font-bold mb-4">Edit Gambar Carousel</h3>

                <form :action="'home-carousel/' + editId" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-1">Gambar Saat Ini</label>
                        <img :src="editImage" alt="Gambar Saat Ini" class="w-full rounded mb-2">
                    </div>

                    <div class="mb-4">
                        <label for="image" class="block text-gray-700">Ganti Gambar (Opsional)</label>
                        <input type="file" name="image" class="mt-1 w-full px-3 py-2 border rounded-md">
                    </div>

                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showEditModal = false"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Update</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Konfirmasi Hapus -->
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 flex items-center justify-center bg-black/50 z-50">
            <div class="bg-white rounded-xl shadow-lg p-6 w-96">
                <h3 class="text-lg font-bold mb-4">Hapus Gambar</h3>
                <p>Yakin ingin menghapus <strong x-text="selectedName"></strong>?</p>
                <form :action="deleteUrl" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showDeleteModal = false"
                            class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Batal</button>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Hapus</button>
                    </div>
                </form>
            </div>
        </div>



    </div>



</x-app-layout>
