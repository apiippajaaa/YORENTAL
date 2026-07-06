<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-xl font-semibold text-gray-800">
                {{ __('Edit Frequently Asked Question') }}
            </h2>

        </div>
    </x-slot>

    <div class="bg-white rounded-lg shadow p-6 mt-6">
        <form action="{{ route('faqs.update', $faq->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="question" class="block text-sm font-medium text-gray-700">Pertanyaan</label>
                <input type="text" name="question" id="question" required
                    value="{{ old('question', $faq->question) }}"
                    class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label for="answer" class="block text-sm font-medium text-gray-700">Jawaban</label>
                <textarea name="answer" id="answer" rows="4" required
                    class="mt-1 block w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('answer', $faq->answer) }}</textarea>
            </div>

            <div class="flex justify-end gap-2">
                <a href="{{ route('faqs.index') }}"
                    class="inline-block bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 transition">
                    ← Kembali
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                    Update FAQ
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
