<x-guest-layout>
    @section('banner')
        <div class="relative w-full h-32 md:h-64 overflow-hidden mb-2 shadow-md">
            <img src="{{ asset('assets/banner/car-list.png') }}" alt="Banner" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                <h1 class="text-white text-2xl md:text-5xl font-semibold drop-shadow-lg">Temukan Mobil Impianmu</h1>
            </div>
        </div>
    @endsection
    <div class="w-full grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6  justify-center">

        @foreach ($cars as $index => $car)
            <div
                class="relative flex w-full flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-[0_3px_10px_rgb(0,0,0,0.2)] mt-8">
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




</x-guest-layout>
