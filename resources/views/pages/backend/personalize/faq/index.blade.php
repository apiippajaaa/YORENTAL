<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Frequently Asked Questions') }}
            </h2>
            <a href="{{ route('faqs.create') }}"
                class="w-full md:w-auto  inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                Tambah FAQ
            </a>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto mt-4">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-3 border-b">No</th>
                    <th class="px-4 py-3 border-b">Pertanyaan</th>
                    <th class="px-4 py-3 border-b">Jawaban</th>
                    <th class="px-4 py-3 border-b">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($faq as $index => $f)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border-b">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border-b">{{ $f->question }}</td>
                        <td class="px-4 py-2 border-b">{{ $f->answer }}</td>
                        <td class="px-4 py-2 border-b">
                            <div class="flex gap-2">
                                <a href="{{ route('faqs.edit', $f->id) }}" class="text-blue-600 hover:underline">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('faqs.destroy', $f->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if ($faq->isEmpty())
            <div class="text-center py-6 text-gray-500">
                Tidak ada data FAQ.
            </div>
        @endif
    </div>
</x-app-layout>
