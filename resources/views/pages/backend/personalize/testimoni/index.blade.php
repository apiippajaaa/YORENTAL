<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Testimoni') }}
            </h2>
            <a href="{{ route('testimonials.create') }}"
                class="w-full md:w-auto bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
                Tambah Testimoni
            </a>
        </div>
    </x-slot>

    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach ($testimonials as $testimonial)
            <div class="bg-white p-6 rounded-lg shadow hover:shadow-md transition">
                <p class="italic text-gray-700">{{ $testimonial->testimonial }}</p>
                <div class="flex items-center mt-4">
                    <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="Foto Testimoni"
                        class="w-12 h-12 rounded-full mr-4 object-cover">
                    <div>
                        <h4 class="font-semibold text-gray-800">{{ $testimonial->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $testimonial->position }}</p>
                    </div>
                </div>

                <div class="flex justify-end gap-4 items-center">
                    <a href="{{ route('testimonials.edit', $testimonial->id) }}"
                        class="text-blue-500 hover:underline text-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    <form action="{{ route('testimonials.destroy', $testimonial->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus testimoni dari {{ $testimonial->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline text-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
</x-app-layout>
