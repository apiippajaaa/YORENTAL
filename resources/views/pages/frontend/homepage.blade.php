<x-guest-layout>



    <div class="HomepageCarouselWrapper relative w-full h-[100px] md:h-[300px]  overflow-hidden rounded-2xl">
        <div class="HomepageCarousel h-full">
            @foreach ($homecarousels as $hc)
                <div>
                    <img src="{{ asset('storage/' . $hc->image) }}" alt="Carousel {{ $loop->iteration }}"
                        class="w-full h-full object-cover object-center" />
                </div>
            @endforeach
        </div>

        <!-- Custom controls -->
        <div class="md:block hidden">
            <button
                class="absolute md:left-2 left-4 top-1/2 -translate-y-1/2 bg-black/40 md:p-2 p-3 rounded-full text-white z-10 homepage-prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button
                class="absolute md:right-2 right-4 top-1/2 -translate-y-1/2 bg-black/40 md:p-2 p-3 rounded-full text-white z-10 homepage-next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>

    <div class="text-center ">
        <h1 class="text-2xl md:text-3xl font-bold text-red-500">
            “Perjalanan Lebih Aman & Nyaman bersama Mau Rental"
        </h1>
        <p class="text-xs md:text-base mt-4 text-gray-500">
            Traveling jadi lebih seru & urusan bisnis makin lancar dengan layanan sewa mobil
            kami! Pilih
            sendiri,
            mau bawa mobilnya atau pakai supir. Armada nyaman, promo menarik, siap antar kamu ke mana saja!
        </p>
    </div>

    <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6  justify-center">
        @foreach ($cars as $index => $car)
            <div
                class="relative flex w-full  flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-[0_3px_10px_rgb(0,0,0,0.2)] mt-8">
                <div
                    class="relative mx-4 -mt-6 h-40 overflow-hidden rounded-xl bg-red-gray-500 bg-clip-border text-white shadow-lg shadow-red-gray-500/40 bg-gradient-to-r from-red-500 to-red-600">
                    @if ($car->photos->isNotEmpty() && $car->photos->first()->photo_path)
                        <img src="{{ asset('storage/' . $car->photos->first()->photo_path) }}" alt="">
                    @else
                        <img src="{{ asset('storage/default.jpg') }}" alt="">
                    @endif
                </div>
                <div class="p-6">
                    <h5
                        class="mb-2 block font-sans text-xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased">
                        {{ $car->name }}
                    </h5>
                    <div class="flex justify-between">
                        <div class="flex gap-1 items-center">
                            <i class="fa-solid fa-wheelchair "></i>
                            <p class="block font-sans text-base font-light leading-relaxed text-inherit antialiased">
                                {{ $car->seats }} Kursi
                            </p>
                        </div>
                        <div class="flex gap-1 items-center">
                            <i class="fa-solid fa-gear"></i>
                            <p class="block font-sans text-base font-light leading-relaxed text-inherit antialiased">
                                {{ $car->transmission }}
                            </p>
                        </div>

                    </div>
                    <div class="divider m-0 p-0"></div>
                    <div class="flex justify-between">
                        <div class="flex items-center gap-1 text-orange-500 font-semibold">
                            <i class="fa-solid fa-circle-half-stroke"></i>
                            <h1>12 Jam</h1>
                        </div>

                        <p class="block font-sans text-base leading-relaxed text-inherit antialiased">
                            Rp. {{ number_format($car->price_per_12_hours, 0, ',', '.') }}
                        </p>

                    </div>
                    <div class="divider m-0 p-0"></div>
                    <div class="flex justify-between">
                        <div class="flex items-center gap-1 text-orange-500 font-semibold">
                            <i class="fa-solid fa-circle"></i>
                            <h1>24 Jam</h1>
                        </div>


                        <p class="block font-sans text-base leading-relaxed text-inherit antialiased">
                            Rp. {{ number_format($car->price_per_day, 0, ',', '.') }}
                        </p>

                    </div>

                    <div class=" pt-3 w-full flex justify-center gap-2">

                        <button data-ripple-light="true" type="button"
                            onclick="window.location.href = '{{ route('booking.create', ['car_id' => $car->id]) }}'"
                            class="btn btn-error text-white flex gap-2">
                            <i class="fa-solid fa-calendar-days"></i>
                            <p>Pesan Sekarang</p>
                        </button>

                        <a href="{{ route('frontend.cars.show', $car->id) }}"
                            class="btn btn-warning text-white flex gap-2">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="flex justify-center mt-4">
        <a href="{{ route('frontend.cars') }}"
            class="relative rounded-md bg-red-500 px-4 py-2
            font-bold text-white transition-colors duration-300 ease-linear before:absolute before:right-1/2
            before:top-1/2 before:-z-[1] before:h-3/4 before:w-2/3 before:origin-bottom-left before:-translate-y-1/2
            before:translate-x-1/2 before:animate-ping before:rounded-md before:bg-red-500 hover:bg-red-700
            hover:before:bg-red-700">Lihat
            Semua Mobil</a>
    </div>
    <div class="divider"></div>
    <section>
        <h1 class="text-3xl font-bold text-center">Testimoni</h1>

        <div class="TestimoniCarouselWrapper relative w-full mx-auto mt-10">
            <div class="TestimoniCarousel flex gap-4">
                @foreach ($testimonials as $testimonial)
                    <div class="max-w-screen-xl px-4 py-8 mx-auto text-center lg:px-6">
                        <figure class="max-w-screen-md mx-auto">
                            <p class="text-xl font-medium text-gray-900 md:text-2xl">
                                {{ $testimonial->testimonial }}
                            </p>
                            <figcaption class="flex items-center justify-center mt-6 space-x-3">
                                <img class="w-6 h-6 rounded-full"
                                    src="{{ $testimonial->photo ? asset('storage/' . $testimonial->photo) : asset('assets/profile/default.webp') }}"
                                    alt="{{ $testimonial->name }}">
                                <div class="flex items-center divide-x-2 divide-gray-500 dark:divide-gray-700">
                                    <div class="pr-3 font-medium text-gray-900">
                                        {{ $testimonial->name }}
                                    </div>

                                    <div class="pl-3 font-medium text-gray-900">
                                        {{ $testimonial->position }}
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                @endforeach
            </div>
            <!-- Tombol Prev & Next -->
            <button
                class="absolute left-0 top-1/2 -translate-y-1/2 bg-black/40 p-3 rounded-full text-white z-10 testimoni-prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button
                class="absolute right-0 top-1/2 -translate-y-1/2 bg-black/40 p-3 rounded-full text-white z-10 testimoni-next">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>

    </section>
    <div class="divider"></div>

    <section x-data="{ openFaq: null }" class="space-y-2">
        <h1 class="text-3xl font-bold text-center">FAQ</h1>
        @foreach ($faqs as $index => $faq)
            <div class="border rounded-md overflow-hidden shadow">
                <button @click="openFaq === {{ $index }} ? openFaq = null : openFaq = {{ $index }}"
                    class="w-full text-left px-4 py-3 bg-gray-100 hover:bg-gray-200 font-semibold flex justify-between items-center">
                    <span>{{ $faq->question }}</span>

                    <svg x-show="openFaq !== {{ $index }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m6-6H6" />
                    </svg>

                    <svg x-show="openFaq === {{ $index }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 12H6" />
                    </svg>
                </button>

                <div x-show="openFaq === {{ $index }}" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-96"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 max-h-96"
                    x-transition:leave-end="opacity-0 max-h-0" class="px-4 py-3 text-sm bg-white overflow-hidden">
                    {{ $faq->answer }}
                </div>
            </div>
        @endforeach
    </section>




    <section class="flex flex-col md:flex-row w-full gap-8 items-center justify-between">
        <div class="w-full md:w-1/2">
            <div class="aspect-w-16 aspect-h-9 w-full">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63258.46118471064!2d110.60639218864911!3d-7.720241237977271!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a47dcc791f43d%3A0x46f2e7d88f656986!2sGantangan%20pandawa!5e0!3m2!1sen!2sid!4v1747592652689!5m2!1sen!2sid"
                    class="w-full h-full rounded-xl border-0" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>

        <!-- Contact Form -->
        <form action="{{ route('contact.send') }}" method="POST"
            class="w-full md:w-1/2 bg-white shadow-md rounded-xl p-6 space-y-4">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                <input type="text" name="name" id="name" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" />
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm" />
            </div>
            <div>
                <label for="message" class="block text-sm font-medium text-gray-700">Pesan</label>
                <textarea name="message" id="message" rows="4" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-red-500 focus:border-red-500 sm:text-sm"></textarea>
            </div>
            <div class="text-right">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none">
                    Kirim Pesan
                </button>
            </div>
        </form>
    </section>



</x-guest-layout>
