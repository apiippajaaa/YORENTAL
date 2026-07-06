<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Penyewaan Mobil') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('car_rentals.update', $rental->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="bg-white p-6 rounded shadow">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        @if (auth()->user()->role == 'admin')
                            <div>
                                <label for="user_id" class="block text-sm font-medium text-gray-700">Pengguna</label>
                                <select id="user_id" name="user_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}" @selected($rental->user_id == $user->id)>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div>
                            <label for="car_id" class="block text-sm font-medium text-gray-700">Mobil</label>
                            <select id="car_id" name="car_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach ($cars as $car)
                                    <option value="{{ $car->id }}"
                                        data-price-per-12-hours="{{ $car->price_per_12_hours }}"
                                        data-price-per-day="{{ $car->price_per_day }}" @selected($rental->car_id == $car->id)>
                                        {{ $car->name }} ({{ $car->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="duration_type" class="block text-sm font-medium text-gray-700">Durasi</label>
                            <select id="duration_type" name="duration_type"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="12" @selected($rental->duration_type == '12')>12 Jam</option>
                                <option value="24" @selected($rental->duration_type == '24')>1 Hari</option>
                                <option value="custom" @selected($rental->duration_type == 'custom')>Custom</option>
                            </select>
                        </div>

                        {{-- <div>
                            <label for="duration_type" class="block text-sm font-medium text-gray-700">Durasi</label>
                            <select id="duration_type" name="duration_type"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="12">12 Jam</option>
                                <option value="24">24 Jam</option>
                                <option value="custom">Lebih dari 1 Hari</option>
                            </select>
                        </div> --}}

                        <div id="custom_duration_container"
                            class="@if ($rental->duration_type == 'custom') block @else hidden @endif">
                            <label for="custom_duration" class="block text-sm font-medium text-gray-700">Jumlah
                                Hari</label>
                            <input type="number" id="custom_duration" name="custom_duration"
                                value="{{ old('custom_duration', $rental->custom_duration) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal
                                Mulai</label>
                            <input type="datetime-local" id="start_date" name="start_date"
                                value="{{ \Carbon\Carbon::parse($rental->start_date)->format('Y-m-d\TH:i') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div>
                            <label for="with_driver" class="block text-sm font-medium text-gray-700">Dengan
                                Supir?</label>
                            <select id="with_driver" name="with_driver"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="0" @selected(!$rental->with_driver)>Tidak</option>
                                <option value="1" @selected($rental->with_driver)>Ya (Rp100.000 per hari)</option>
                            </select>
                        </div>

                        <div id="driver_days_container"
                            class="@if ($rental->with_driver) block @else hidden @endif">
                            <label for="driver_days" class="block text-sm font-medium text-gray-700">Jumlah Hari
                                Supir</label>
                            <input type="number" id="driver_days" name="driver_days"
                                value="{{ old('driver_days', $rental->driver_days ?? 1) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1">
                        </div>

                        <div>
                            <label for="with_fuel" class="block text-sm font-medium text-gray-700">Termasuk BBM?</label>
                            <select id="with_fuel" name="with_fuel"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="0" @selected(!$rental->with_fuel)>Tidak</option>
                                <option value="1" @selected($rental->with_fuel)>Ya (Rp200.000 / hari)</option>
                            </select>
                        </div>

                        <div id="fuel_days_container"
                            class="@if ($rental->with_fuel) block @else hidden @endif">
                            <label for="fuel_days" class="block text-sm font-medium text-gray-700">Jumlah Hari
                                BBM</label>
                            <input type="number" id="fuel_days" name="fuel_days"
                                value="{{ old('fuel_days', $rental->fuel_days ?? 1) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" min="1">
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status
                                Pemesanan</label>
                            <select id="status" name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="menunggu_konfirmasi"
                                    {{ old('status', $rental->status) == 'menunggu_konfirmasi' ? 'selected' : '' }}>
                                    Menunggu Konfirmasi</option>
                                <option value="booked"
                                    {{ old('status', $rental->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                                <option value="on_rent"
                                    {{ old('status', $rental->status) == 'on_rent' ? 'selected' : '' }}>On Rent
                                </option>
                                <option value="selesai"
                                    {{ old('status', $rental->status) == 'selesai' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="dibatalkan"
                                    {{ old('status', $rental->status) == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan
                                </option>
                                <option value="ditolak"
                                    {{ old('status', $rental->status) == 'ditolak' ? 'selected' : '' }}>Ditolak
                                </option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Total Harga</label>
                            <div id="total_price_display" class="mt-2 text-lg">
                                @if ($rental->discount && $rental->discount > 0)
                                    <div>
                                        <div>
                                            <span class="line-through text-red-500 mr-2 block">
                                                {{ number_format($rental->total_price + $rental->discount, 0, ',', '.') }}
                                            </span>
                                            <span class="font-bold text-green-700 text-xl">
                                                {{ number_format($rental->total_price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                        <div class="text-sm text-gray-500 mt-1">
                                            (Diskon {{ number_format($rental->discount, 0, ',', '.') }})
                                        </div>
                                    </div>
                                @else
                                    <span class="font-bold text-green-700 text-xl">
                                        {{ number_format($rental->total_price, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>


                            <input type="hidden" name="total_price" id="total_price"
                                value="{{ $rental->total_price }}">
                        </div>

                        {{-- <div>
                            <label class="block text-sm font-medium text-gray-700">Diskon</label>
                            <p id="discount_display" class="mt-2 text-red-500 font-semibold">
                                {{ isset($rental->discount) ? 'Rp' . number_format($rental->discount, 0, ',', '.') : 'Rp0' }}
                            </p>
                        </div> --}}
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Perbarui</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const carSelect = document.getElementById('car_id');
        const durationSelect = document.getElementById('duration_type');
        const customDaysContainer = document.getElementById('custom_duration_container');
        const customDaysInput = document.getElementById('custom_duration');
        const driverType = document.getElementById('driver_type');
        const fuelOption = document.getElementById('with_fuel');
        const totalDisplay = document.getElementById('total_price_display');
        const totalInput = document.getElementById('total_price');

        const withDriver = document.getElementById('with_driver');
        const driverDaysContainer = document.getElementById('driver_days_container');
        const driverDaysInput = document.getElementById('driver_days');

        const fuelDaysContainer = document.getElementById('fuel_days_container');
        const fuelDaysInput = document.getElementById('fuel_days');

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        function calculateTotal() {
            const selectedCar = carSelect.options[carSelect.selectedIndex];
            const price12 = parseInt(selectedCar.getAttribute('data-price-per-12-hours')) || 0;
            const priceDay = parseInt(selectedCar.getAttribute('data-price-per-day')) || 0;

            let baseTotal = 0;
            let discount = 0;
            let days = 1;

            const duration = durationSelect.value;

            if (duration === '12') {
                baseTotal = price12;
                days = 1;
            } else if (duration === '24') {
                baseTotal = priceDay;
                days = 1;
            } else if (duration === 'custom') {
                days = parseInt(customDaysInput.value) || 1;
                baseTotal = priceDay * days;
                discount = Math.floor(days / 3) * 50000;
            }

            let total = baseTotal - discount;

            // Supir per hari
            const withDriver = document.getElementById('with_driver').value;
            if (withDriver === '1') total += 200000 * days;

            // BBM per hari
            const fuel = fuelOption.value;
            if (fuel === '1') total += 200000 * days;

            if (discount > 0 && duration === 'custom') {
                totalDisplay.innerHTML = `
        <div>
            <span class="line-through text-red-500 block">${formatRupiah(baseTotal)}</span>
            <span class="font-bold text-green-700 text-xl block">${formatRupiah(total)}</span>
            <span class="text-sm text-gray-500 mt-1 block">(Diskon ${formatRupiah(discount)})</span>
        </div>`;
            } else {
                totalDisplay.innerHTML = `<span class="font-bold text-green-700 text-xl">${formatRupiah(total)}</span>`;
            }

            totalInput.value = total;
        }

        withDriver.addEventListener('change', () => {
            if (withDriver.value === '1') {
                driverDaysContainer.classList.remove('hidden');
            } else {
                driverDaysContainer.classList.add('hidden');
                driverDaysInput.value = 0;
            }
            calculateTotal();
        });

        fuelOption.addEventListener('change', () => {
            if (fuelOption.value === '1') {
                fuelDaysContainer.classList.remove('hidden');
            } else {
                fuelDaysContainer.classList.add('hidden');
                fuelDaysInput.value = 0;
            }
            calculateTotal();
        });


        durationSelect.addEventListener('change', () => {
            if (durationSelect.value === 'custom') {
                customDaysContainer.classList.remove('hidden');
            } else {
                customDaysContainer.classList.add('hidden');
                customDaysInput.value = '';
            }
            calculateTotal();
        });

        [carSelect, customDaysInput, driverType, fuelOption].forEach(el => {
            el.addEventListener('change', calculateTotal);
        });

        window.addEventListener('DOMContentLoaded', () => {
            calculateTotal();
        });
    </script>

</x-app-layout>
