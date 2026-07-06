<x-guest-layout>
    @section('banner')
        <div class="relative w-full h-32 md:h-64 overflow-hidden mb-2 shadow-md">
            <img src="{{ asset('assets/banner/contact-us.jpg') }}" alt="Banner" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                <h1 class="text-white text-2xl md:text-5xl font-semibold drop-shadow-lg">Hubungi Kami</h1>
            </div>
        </div>
    @endsection

    @php
        $colors = ['bg-red-500', 'bg-blue-500', 'bg-green-500', 'bg-yellow-500', 'bg-purple-500'];
    @endphp

    <section class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
        @foreach ($links as $i => $l)
            @php
                $bgColor = $colors[$i % count($colors)];
            @endphp

            {{-- Mobile Layout --}}
            <a href="{{ $l->url }}" target="_blank"
                class="flex flex-col items-center justify-center {{ $bgColor }} text-white p-4 rounded-md
                  transform transition duration-200 hover:scale-105 active:scale-95 md:hidden">
                <i class="{{ $l->icon }} text-2xl mb-2"></i>
                <h1 class="text-xs font-semibold">{{ $l->account }}</h1>
            </a>

            {{-- Desktop Layout --}}
            <a href="{{ $l->url }}" target="_blank"
                class="hidden md:flex items-center gap-4 {{ $bgColor }} text-white p-4 rounded-md
                  transform transition duration-200 hover:scale-105 active:scale-95">
                <div>
                    <i class="{{ $l->icon }} text-3xl"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold">{{ $l->title }}</h2>
                    <h1 class="text-base font-bold">{{ $l->account }}</h1>
                </div>
            </a>
        @endforeach
    </section>



    <section class="w-full pb-12 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 items-center md:px-0">
        <!-- Google Maps Iframe -->
        <div class="w-full">
            <div class="aspect-video w-full">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63258.46118471064!2d110.60639218864911!3d-7.720241237977271!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a47dcc791f43d%3A0x46f2e7d88f656986!2sGantangan%20pandawa!5e0!3m2!1sen!2sid!4v1747592652689!5m2!1sen!2sid"
                    width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" class="rounded-xl w-full h-full"></iframe>
            </div>
        </div>

        <!-- Contact Form -->
        <form action="{{ route('contact.send') }}" method="POST"
            class="bg-white shadow-md rounded-xl p-6 w-full space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm">
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                <textarea name="message" id="message" rows="4" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"></textarea>
            </div>

            <div class="text-right">
                <button type="submit"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                    Kirim Pesan
                </button>
            </div>
        </form>
    </section>

</x-guest-layout>
