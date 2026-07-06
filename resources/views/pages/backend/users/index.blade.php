<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Frequently Asked Question') }}
            </h2>

            <a href="{{ route('faqs.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Tambah FAQ
            </a>
        </div>
    </x-slot>


    <div x-data="{
        showDeleteModal: false,
        deleteUrl: '',
        selectedName: '',
    }" class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2 w-1/2">Nama</th>
                    <th class="px-4 py-2 w-1/2">Email</th>
                    <th class="px-4 py-2 w-1/2">No HP/WA</th>
                    <th class="px-4 py-2 w-1/2">Alamat</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faq as $index => $f)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                        <td class="px-4 py-2">{{ $f->question }}</td>
                        <td class="px-4 py-2">{{ $f->answer }}</td>
                        <td class="px-4 py-2 flex gap-4">
                            <a href="{{ route('faqs.edit', $f) }}" class="btn btn-success">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            <!-- Tombol Hapus -->
                            <button
                                @click="showDeleteModal = true; deleteUrl = '{{ route('faqs.destroy', $f) }}'; selectedName = 'Gambar ID: {{ $f->id }}';"
                                class="btn btn-error text-red-600 hover:text-red-800 transition duration-200">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

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
