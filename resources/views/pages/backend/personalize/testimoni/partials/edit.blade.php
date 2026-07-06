<x-app-layout>
    <div class="max-w-xl mx-auto px-4 py-6">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">Edit Testimoni</h1>

        <form action="{{ route('testimonials.update', $testimonial) }}" method="POST" enctype="multipart/form-data"
            class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="testimonial" class="block text-sm font-medium text-gray-700">Testimoni</label>
                <textarea name="testimonial" id="testimonial" rows="4"
                    class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>{{ old('testimonial', $testimonial->testimonial) }}</textarea>
            </div>

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name"
                    class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('name', $testimonial->name) }}" required>
            </div>

            <div>
                <label for="position" class="block text-sm font-medium text-gray-700">Posisi</label>
                <input type="text" name="position" id="position"
                    class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    value="{{ old('position', $testimonial->position) }}" required>
            </div>

            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700">Foto (Opsional)</label>
                <input type="file" name="photo" id="photo"
                    class="mt-1 w-full px-4 py-2 border rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

                @if ($testimonial->photo)
                    <div class="mt-2">
                        <p class="text-sm text-gray-600 mb-1">Foto saat ini:</p>
                        <img src="{{ asset('storage/' . $testimonial->photo) }}" alt="Foto Testimoni"
                            class="w-16 h-16 rounded-full object-cover">
                    </div>
                @endif
            </div>

            <div class=" flex justify-end gap-2">
                <a href="{{ route('testimonials.index') }}"
                    class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                    ← Kembali
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
