<x-app-layout>
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Personalisasi') }}
    </h2>

    <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mt-8">
        <a href="{{ route('home-carousel.index') }}"
            class="p-6 rounded-lg shadow text-center bg-red-500 text-white text-xl font-semibold hover:bg-red-600 transition">
            Home Carousel
        </a>

        <a href="{{ route('faqs.index') }}"
            class="p-6 rounded-lg shadow text-center bg-slate-500 text-white text-xl font-semibold hover:bg-slate-600 transition">
            FAQ
        </a>

        <a href="{{ route('testimonials.index') }}"
            class="p-6 rounded-lg shadow text-center bg-blue-500 text-white text-xl font-semibold hover:bg-blue-600 transition">
            Testimoni
        </a>

        <a href="{{ route('links.index') }}"
            class="p-6 rounded-lg shadow text-center bg-green-500 text-white text-xl font-semibold hover:bg-green-600 transition">
            Links
        </a>
    </section>
</x-app-layout>
