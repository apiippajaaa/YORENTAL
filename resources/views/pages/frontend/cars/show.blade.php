<x-guest-layout>
    <div class="w-full mx-auto py-4 md:py-12 px-4 lg:px-12">
        <div class="flex flex-col lg:flex-row gap-8">

            <!-- Carousel Wrapper -->
            <div
                class="CarDetailWrapper relative w-full lg:w-1/2 h-44 md:h-96 bg-white rounded-2xl shadow-xl overflow-hidden">

                <!-- Carousel Images -->
                <div class="CarDetailCarousel h-full w-full">
                    @forelse ($car->photos as $photo)
                        <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Foto Mobil"
                            class="w-full h-full object-cover object-center transition-all duration-500 ease-in-out rounded-2xl">

                    @empty
                        <div class="flex items-center justify-center h-full bg-gray-100 rounded-2xl">
                            <p class="text-gray-500 text-lg">Tidak ada foto.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Carousel Navigation -->
                <button
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-black/80 p-3 rounded-full text-white z-10 car-detail-prev transition duration-300">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/60 hover:bg-black/80 p-3 rounded-full text-white z-10 car-detail-next transition duration-300">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Detail Mobil -->
            <div class="flex-1 space-y-4">
                <h2 class="text-3xl font-bold text-gray-800">{{ $car->name }}</h2>
                <p class="text-gray-600 text-lg">{{ $car->description }}</p>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4 text-sm text-gray-700">
                    <div>
                        <span class="font-semibold">Merek:</span>
                        <div>{{ $car->category->name ?? '-' }}</div>
                    </div>
                    <div>
                        <span class="font-semibold">Plat Nomer:</span>
                        <div>{{ $car->plate_number }}</div>
                    </div>
                    <div>
                        <span class="font-semibold">Transmisi:</span>
                        <div>{{ $car->transmission }}</div>
                    </div>
                    <div>
                        <span class="font-semibold">Tahun:</span>
                        <div>{{ $car->year }}</div>
                    </div>
                    <div>
                        <span class="font-semibold">Warna:</span>
                        <div>{{ $car->color }}</div>
                    </div>
                    <div>
                        <span class="font-semibold">Jumlah Kursi:</span>
                        <div>{{ $car->seats }}</div>
                    </div>
                    <div>
                        <span class="font-semibold">Harga Sewa:</span>
                        <div class="text-red-600 font-semibold">
                            {{ number_format($car->price_per_12_hours, 0, ',', '.') }}
                            /12 Jam</div>
                    </div>
                    <div>
                        <span class="font-semibold">Harga Sewa:</span>
                        <div class="text-red-600 font-semibold">{{ number_format($car->price_per_day, 0, ',', '.') }}
                            /hari</div>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('booking.create', ['car_id' => $car->id]) }}"
                        class="inline-block px-6 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition">
                        Sewa Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
