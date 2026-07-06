<x-app-layout>
    <div class="container py-6">

        <!-- Judul dan aksi -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="font-semibold text-3xl text-gray-800">{{ $car->name }}</h1>
            <div class="flex gap-3">
                <a href="{{ route('cars.edit', $car->id) }}"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                    Edit
                </a>

                <!-- Tombol Hapus dengan confirm JS -->
                <form id="delete-form" action="{{ route('cars.destroy', $car->id) }}" method="POST"
                    onsubmit="return false;">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        onclick="if(confirm('Yakin ingin menghapus {{ $car->name }}?')) { this.closest('form').submit(); }"
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                        Hapus
                    </button>
                </form>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Carousel Foto Mobil -->
            <div
                class="CarDetailWrapper relative w-full lg:w-1/2 h-56 md:h-96 overflow-hidden rounded-2xl bg-white shadow-lg">
                <div class="CarDetailCarousel h-full rounded-xl overflow-hidden relative  bg-white">
                    @forelse ($car->photos as $photo)
                        <div class=" rounded-xl overflow-hidden">
                            <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Foto Mobil"
                                class="w-full  object-cover object-center rounded-xl transition-transform duration-300 hover:scale-150" />
                        </div>
                    @empty
                        <p class="text-center text-gray-500">Tidak ada foto.</p>
                    @endforelse
                </div>

                <!-- Navigasi -->
                <button
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 p-3 rounded-full text-white z-20 car-detail-prev hover:bg-black/70 shadow-lg transition">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 p-3 rounded-full text-white z-20 car-detail-next hover:bg-black/70 shadow-lg transition">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Detail Info Mobil -->
            <div class="w-full lg:w-1/2">
                <div class="bg-white p-6 rounded-xl shadow-lg space-y-4 h-96">
                    @php
                        $details = [
                            ['label' => 'Kategori', 'value' => $car->category->name ?? '-', 'icon' => 'fa-car'],
                            ['label' => 'Nomor Polisi', 'value' => $car->plate_number ?? '-', 'icon' => 'fa-id-card'],
                            ['label' => 'Jumlah Kursi', 'value' => $car->seats ?? '-', 'icon' => 'fa-chair'],
                            ['label' => 'Warna', 'value' => $car->color ?? '-', 'icon' => 'fa-palette'],
                            ['label' => 'Transmisi', 'value' => $car->transmission ?? '-', 'icon' => 'fa-cogs'],
                            ['label' => 'Tahun', 'value' => $car->year ?? '-', 'icon' => 'fa-calendar'],
                            [
                                'label' => 'Price / 12 jam',
                                'value' => $car->price_per_12_hours
                                    ? 'Rp. ' . number_format($car->price_per_12_hours, 0, ',', '.')
                                    : '-',
                                'icon' => 'fa-solid fa-circle-half-stroke',
                            ],
                            [
                                'label' => 'Price / Hari',
                                'value' => $car->price_per_day
                                    ? 'Rp. ' . number_format($car->price_per_day, 0, ',', '.')
                                    : '-',
                                'icon' => 'fa-solid fa-circle',
                            ],
                        ];
                        $description = $car->description ?? '-';
                    @endphp

                    <!-- Grid Detail -->
                    <div class="grid grid-cols-2  md:grid-cols-2 lg:grid-cols-4 gap-4 ">
                        @foreach ($details as $item)
                            <div class="text-sm">
                                <div class="flex items-center gap-1 font-semibold text-red-600">
                                    <i class="fas {{ $item['icon'] }} text-sm"></i>
                                    <span>{{ $item['label'] }}</span>
                                </div>
                                <div class="text-gray-900">{{ $item['value'] }}</div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Deskripsi -->
                    <div class="pt-4 border-t">
                        <div class="flex items-center gap-1 font-semibold text-red-600 mb-1">
                            <i class="fas fa-info-circle text-sm"></i>
                            <span>Deskripsi</span>
                        </div>
                        <div class="text-gray-900 text-sm leading-relaxed">
                            {{ $description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <!-- Pastikan tiny-slider sudah kamu include -->
        <script src="{{ asset('path/to/tiny-slider.js') }}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const sliderCarDetail = tns({
                    container: ".CarDetailCarousel",
                    items: 1,
                    slideBy: "page",
                    autoplay: true,
                    controls: false,
                    nav: false,
                    autoplayButtonOutput: false,
                    speed: 400,
                    mouseDrag: true,
                });

                document.querySelector(".car-detail-prev")?.addEventListener("click", () => sliderCarDetail.goTo(
                    "prev"));
                document.querySelector(".car-detail-next")?.addEventListener("click", () => sliderCarDetail.goTo(
                    "next"));
            });
        </script>
    @endpush
</x-app-layout>
