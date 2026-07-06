<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Penyewaan Mobil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pengguna</label>
                        <p class="mt-1 text-gray-900">{{ $rental->user->name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Mobil</label>
                        <p class="mt-1 text-gray-900">{{ $rental->car->name }} ({{ $rental->car->plate_number }})</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Durasi</label>
                        <p class="mt-1 text-gray-900">
                            @if ($rental->duration_type === 'custom')
                                {{ $rental->custom_duration }} Hari
                            @else
                                {{ $rental->duration_type }} Jam
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Mulai Sewa</label>
                        <p class="mt-1 text-gray-900">
                            {{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y H:i') }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Selesai Sewa</label>
                        <p class="mt-1 text-gray-900">
                            {{ $rental->end_date ? \Carbon\Carbon::parse($rental->end_date)->format('d M Y H:i') : '-' }}
                        </p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <p class="mt-1 text-gray-900 capitalize">{{ str_replace('_', ' ', $rental->status) }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dengan Supir?</label>
                        <p class="mt-1 text-gray-900">{{ $rental->with_driver ? 'Ya' : 'Tidak' }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dengan BBM?</label>
                        <p class="mt-1 text-gray-900">{{ $rental->with_fuel ? 'Ya' : 'Tidak' }}</p>
                    </div>

                    {{-- Detail Harga --}}
                    @php
                        $isCustom = $rental->duration_type === 'custom';
                        $days = $isCustom ? $rental->custom_duration : ($rental->duration_type === '24' ? 1 : 0.5);
                        $carPrice = $isCustom
                            ? $rental->car->price_per_day * $days
                            : ($rental->duration_type === '24'
                                ? $rental->car->price_per_day
                                : $rental->car->price_per_12_hours);
                        $discount = $rental->discount ?? 0;

                        $driverPrice = $rental->with_driver ? 200000 * ($rental->driver_days ?? ceil($days)) : 0;
                        $fuelPrice = $rental->with_fuel ? 200000 * ($rental->fuel_days ?? ceil($days)) : 0;

                        $totalSebelumDiskon = $carPrice + $driverPrice + $fuelPrice;
                        $totalSetelahDiskon = $totalSebelumDiskon - $discount;
                    @endphp

                    <div class="col-span-2">
                        <h3 class="text-lg font-bold mb-2">Rincian Harga</h3>
                        <div class="space-y-1 text-sm">
                            <div class="flex justify-between">
                                <span>Harga Sewa Mobil ( {{ $days }} Hari )</span>
                                <span>Rp{{ number_format($carPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Biaya Supir ( {{ $rental->driver_days ?? ceil($days) }} Hari )</span>
                                <span>Rp{{ number_format($driverPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Biaya BBM ( {{ $rental->fuel_days ?? ceil($days) }} Hari )</span>
                                <span>Rp{{ number_format($fuelPrice, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-red-600">
                                <span>Diskon</span>
                                <span>- Rp{{ number_format($discount, 0, ',', '.') }}</span>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between font-semibold text-green-700">
                                <span>Total Harga</span>
                                <span>Rp{{ number_format($totalSetelahDiskon, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Dokumen --}}
                    <div x-data="{ openModal: null }" class="col-span-2">
                        @if ($rental->documents->count())
                            <label class="block text-sm font-medium text-gray-700 mb-2">Dokumen Terlampir</label>

                            <ul class="list-disc list-inside space-y-1 text-sm text-blue-700">
                                @foreach ($rental->documents as $i => $doc)
                                    <li>
                                        <button @click="openModal = {{ $i }}" class="hover:underline">
                                            {{ basename($doc->file_path) }}
                                        </button>

                                        <div x-show="openModal === {{ $i }}" @click.away="openModal = null"
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
                                            x-cloak>
                                            <div @click.stop
                                                class="bg-white rounded-lg shadow-lg p-4 max-w-xl w-full relative">
                                                <button @click="openModal = null"
                                                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-800 text-lg">&times;</button>

                                                <h3 class="text-lg font-semibold mb-2">Preview Dokumen</h3>

                                                @if (Str::endsWith($doc->file_path, ['.jpg', '.jpeg', '.png']))
                                                    <img src="{{ asset('storage/' . $doc->file_path) }}"
                                                        class="w-full rounded">
                                                @else
                                                    <iframe src="{{ asset('storage/' . $doc->file_path) }}"
                                                        class="w-full h-96 rounded"></iframe>
                                                @endif
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('car_rentals.index') }}"
                        class="inline-block bg-gray-300 px-4 py-2 rounded hover:bg-gray-400">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
