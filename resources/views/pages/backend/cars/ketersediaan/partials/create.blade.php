<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Penyewaan Mobil') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('car_rentals.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="bg-white p-6 rounded shadow">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        @if (auth()->user()->role == 'admin')
                            <div>
                                <label for="nama_perental" class="block text-sm font-medium text-gray-700">Nama Penyewa
                                    Offline</label>
                                <input type="text" name="nama_perental" id="nama_perental"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                    placeholder="Masukkan nama penyewa offline..." required>
                            </div>
                        @endif


                        <div>
                            <label for="car_id" class="block text-sm font-medium text-gray-700">Mobil</label>
                            <select id="car_id" name="car_id"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach ($cars as $car)
                                    <option value="{{ $car->id }}"
                                        data-price-per12hours="{{ $car->price_per_12_hours }}"
                                        data-price-per-day="{{ $car->price_per_day }}">
                                        {{ $car->name }} ({{ $car->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="duration_type" class="block text-sm font-medium text-gray-700">Durasi</label>
                            <select id="duration_type" name="duration_type"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="12">12 Jam</option>
                                <option value="24">24 Jam</option>
                                <option value="custom">Lebih dari 1 Hari</option>
                            </select>
                        </div>

                        <div id="custom_days_wrapper" class="hidden">
                            <label for="custom_duration" class="block text-sm font-medium text-gray-700">Jumlah
                                Hari</label>
                            <input type="number" min="2" id="custom_days" name="custom_duration"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Contoh: 3">
                        </div>

                        <!-- Tanggal Mulai -->
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai
                                Sewa</label>
                            <input type="datetime-local" id="start_date" name="start_date"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        {{-- Sopir --}}
                        <div class="mb-4">
                            <label for="with_driver" class="block text-sm font-medium text-gray-700">Butuh
                                Sopir?</label>
                            <select name="with_driver" id="with_driver"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>

                        <div class="mb-4 hidden" id="driver_days_wrapper">
                            <label for="driver_days" class="block text-sm font-medium text-gray-700">Jumlah Hari
                                Sopir</label>
                            <input type="number" name="driver_days" id="driver_days" min="1"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Misal: 3">
                        </div>

                        {{-- BBM --}}
                        <div class="mb-4">
                            <label for="with_fuel" class="block text-sm font-medium text-gray-700">Termasuk Biaya
                                BBM?</label>
                            <select name="with_fuel" id="with_fuel"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="0">Tidak</option>
                                <option value="1">Ya</option>
                            </select>
                        </div>

                        <div class="mb-4 hidden" id="fuel_days_wrapper">
                            <label for="fuel_days" class="block text-sm font-medium text-gray-700">Jumlah Hari untuk
                                BBM</label>
                            <input type="number" name="fuel_days" id="fuel_days" min="1"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Misal: 2">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Dokumen (KTP, SIM,
                            dll)</label>

                        <input id="documentInput" type="file" class="hidden" />
                        <button type="button" onclick="triggerFileInput()"
                            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm">Tambah Dokumen</button>

                        <div id="documentPreview" class="mt-3 space-y-2">
                            <!-- File list akan muncul di sini -->
                        </div>
                    </div>

                    {{-- <div class="mt-6">
                        <p class="text-lg font-semibold">Estimasi Total:
                            <span id="total_price_display" class="text-green-600">Rp0</span>
                        </p>
                        <input type="hidden" id="total_price" name="total_price" value="0">
                    </div> --}}

                    <div class="mt-6 bg-gray-100 p-4 rounded space-y-2 text-sm text-gray-800">
                        {{-- Harga Sewa Mobil --}}
                        <div class="flex justify-between">
                            <span>Harga Sewa Mobil</span>
                            <span id="car_price">Rp 0</span>
                        </div>

                        {{-- Biaya Supir --}}
                        <div class="flex justify-between">
                            <span>Biaya Supir (<span id="driver_days_text">0</span> Hari)</span>
                            <span id="driver_price">Rp 0</span>
                        </div>

                        {{-- Biaya BBM --}}
                        <div class="flex justify-between">
                            <span>Biaya BBM (<span id="fuel_days_text">0</span> Hari)</span>
                            <span id="fuel_price">Rp 0</span>
                        </div>

                        <hr class="my-2">

                        {{-- Total Sebelum Diskon --}}
                        <div class="flex justify-between font-medium">
                            <span>Total Sebelum Diskon</span>
                            <span id="total_before_discount">Rp 0</span>
                        </div>

                        {{-- Diskon --}}
                        <div class="flex justify-between text-green-700">
                            <span>Diskon</span>
                            <span id="discount_amount">- Rp 0</span>
                        </div>

                        <hr class="my-2">

                        {{-- Total Setelah Diskon --}}
                        <div class="flex justify-between font-bold text-primary text-base">
                            <span>Total Setelah Diskon</span>
                            <span id="estimated_total">Rp 0</span>
                        </div>

                        {{-- Hidden input untuk form --}}
                        <input type="hidden" id="total_price" name="total_price" value="0">
                    </div>




                    <div class="mt-6">
                        <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan
                            Penyewaan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const carSelect = document.getElementById('car_id');
        const durationSelect = document.getElementById('duration_type');
        const customDaysInput = document.getElementById('custom_days');

        const withDriver = document.getElementById('with_driver');
        const driverDaysInput = document.getElementById('driver_days');
        const driverWrapper = document.getElementById('driver_days_wrapper');

        const withFuel = document.getElementById('with_fuel');
        const fuelDaysInput = document.getElementById('fuel_days');
        const fuelWrapper = document.getElementById('fuel_days_wrapper');

        const originalPriceWrapper = document.getElementById('original_price_wrapper');
        const originalPrice = document.getElementById('original_price');
        const discountAmount = document.getElementById('discount_amount');
        const estimatedTotal = document.getElementById('estimated_total');
        const totalPriceInput = document.getElementById('total_price');

        const driverPricePerDay = 200000;
        const fuelPricePerDay = 200000;

        function getCarPrice() {
            const selectedOption = carSelect.options[carSelect.selectedIndex];
            return {
                pricePer12: parseInt(selectedOption.dataset.pricePer12hours || 0),
                pricePerDay: parseInt(selectedOption.dataset.pricePerDay || 0)
            };
        }

        function calculate() {
            const duration = durationSelect.value;

            const customDaysWrapper = document.getElementById('custom_days_wrapper');
            const showCustomDays = duration === 'custom';
            customDaysWrapper.classList.toggle('hidden', !showCustomDays);
            customDaysInput.required = showCustomDays;

            const customDays = parseInt(customDaysInput.value) || 1;

            const carPrice = getCarPrice();
            let base = 0;
            let days = 1;
            let discount = 0;

            if (duration === '12') {
                base = carPrice.pricePer12;
                days = 0.5;
            } else if (duration === '24') {
                base = carPrice.pricePerDay;
                days = 1;
            } else {
                base = customDays * carPrice.pricePerDay;
                days = customDays;
                discount = Math.floor(customDays / 3) * 50000;
            }

            // Sopir
            const showDriver = withDriver.value === '1';
            driverWrapper.classList.toggle('hidden', !showDriver);
            const driverDays = showDriver ? parseInt(driverDaysInput.value) || 1 : 0;
            const driverCost = driverDays * driverPricePerDay;

            // BBM
            const showFuel = withFuel.value === '1';
            fuelWrapper.classList.toggle('hidden', !showFuel);
            const fuelDays = showFuel ? parseInt(fuelDaysInput.value) || 1 : 0;
            const fuelCost = fuelDays * fuelPricePerDay;

            const totalBeforeDiscount = base + driverCost + fuelCost;
            const total = totalBeforeDiscount - discount;

            // Tambahan ini — update semua elemen harga
            document.getElementById('car_price').textContent = 'Rp ' + base.toLocaleString('id-ID');
            document.getElementById('driver_price').textContent = 'Rp ' + driverCost.toLocaleString('id-ID');
            document.getElementById('fuel_price').textContent = 'Rp ' + fuelCost.toLocaleString('id-ID');

            document.getElementById('driver_days_text').textContent = driverDays;
            document.getElementById('fuel_days_text').textContent = fuelDays;

            document.getElementById('total_before_discount').textContent = 'Rp ' + totalBeforeDiscount.toLocaleString(
                'id-ID');
            document.getElementById('discount_amount').textContent = '- Rp ' + discount.toLocaleString('id-ID');
            document.getElementById('estimated_total').textContent = 'Rp ' + total.toLocaleString('id-ID');

            totalPriceInput.value = total;

            originalPriceWrapper.style.display = discount > 0 ? 'block' : 'none';
        }


        // Listener
        [carSelect, durationSelect, customDaysInput, withDriver, driverDaysInput, withFuel, fuelDaysInput].forEach(el => {
            el.addEventListener('input', calculate);
            el.addEventListener('change', calculate);
        });

        document.addEventListener('DOMContentLoaded', calculate);
    </script>






    <script>
        const fileInput = document.getElementById('documentInput');
        const previewContainer = document.getElementById('documentPreview');
        let fileCount = 0;

        function triggerFileInput() {
            fileInput.click();
        }

        fileInput.addEventListener('change', () => {
            const file = fileInput.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = () => {
                const wrapper = document.createElement('div');
                wrapper.classList.add('flex', 'items-center', 'justify-between', 'bg-gray-100', 'p-2',
                    'rounded');

                wrapper.innerHTML = `
                <span class="text-sm truncate max-w-xs">${file.name}</span>
                <button type="button" class="text-red-600 text-xs hover:underline" onclick="this.parentElement.remove()">Hapus</button>
                <input type="hidden" name="documents[${fileCount}]" />
            `;

                // Karena kita gak bisa set file ke hidden input, kita clone via DataTransfer
                const dt = new DataTransfer();
                dt.items.add(file);

                const realInput = document.createElement('input');
                realInput.type = 'file';
                realInput.name = 'documents[]';
                realInput.classList.add('hidden');
                realInput.files = dt.files;
                wrapper.appendChild(realInput);

                previewContainer.appendChild(wrapper);
                fileCount++;

                fileInput.value = ''; // reset input supaya bisa upload file dengan nama sama lagi
            };
            reader.readAsDataURL(file);
        });
    </script>
</x-app-layout>
