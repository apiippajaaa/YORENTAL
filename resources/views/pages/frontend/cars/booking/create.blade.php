<x-guest-layout>
    @section('banner')
        <div class="relative w-full h-32 md:h-64 overflow-hidden mb-2 shadow-md">
            <img src="{{ asset('assets/banner/booking-list.jpg') }}" alt="Banner" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center flex-col gap-2">
                <h1 class="text-white text-2xl md:text-5xl font-semibold drop-shadow-lg">Form Booking</h1>
                <p class="text-white text-base md:text-base drop-shadow-lg">(Silahkan isi form di bawah ini)</p>
            </div>
        </div>
    @endsection

    <div class="w-full md:mx-auto md:px-6">
        <div class="card shadow-xl bg-base-100">
            <div class="card-body ">
                <h2 class="card-title text-2xl">Booking Mobil: {{ $car->name }}</h2>
                <p class="text-sm text-gray-500 mb-4">
                    Harga 12 jam: <span class="font-semibold text-primary">Rp
                        {{ number_format($car->price_per_12_hours) }}</span><br>
                    Harga 24 jam: <span class="font-semibold text-primary">Rp
                        {{ number_format($car->price_per_day) }}</span><br>
                </p>

                @if ($errors->any())
                    <div class="alert alert-error mt-4">
                        <ul class="list-disc ml-4">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="car_id" value="{{ $car->id }}">

                    {{-- Duration Type --}}
                    <div class="mb-4">
                        <label class="label">Durasi Sewa</label>
                        <select name="duration_type" id="duration_type" class="select select-bordered w-full" required>
                            <option value="">-- Pilih Durasi --</option>
                            <option value="12">12 Jam</option>
                            <option value="24">24 Jam</option>
                            <option value="custom">Custom (hari)</option>
                        </select>
                    </div>

                    {{-- Start Date --}}
                    <div class="mb-4">
                        <label class="label">Tanggal Mulai</label>
                        <input type="datetime-local" name="start_date" id="start_date"
                            class="input input-bordered w-full" required min="{{ now()->format('Y-m-d\TH:i') }}">
                    </div>

                    {{-- Jumlah Hari --}}
                    <div class="mb-4 hidden" id="custom_days_wrapper">
                        <label class="label">Jumlah Hari</label>
                        <input type="number" name="custom_duration" id="custom_days"
                            class="input input-bordered w-full" min="2" placeholder="Isi jumlah hari sewa">
                    </div>

                    {{-- Sopir --}}
                    <div class="mb-4">
                        <label class="label">Butuh Sopir?</label>
                        <select name="with_driver" id="driver_option" class="select select-bordered w-full" required>
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>

                    <div class="mb-4 hidden" id="driver_days_wrapper">
                        <label class="label">Jumlah Hari Sopir</label>
                        <input type="number" name="driver_days" id="driver_days" class="input input-bordered w-full"
                            min="1" placeholder="Misal: 3">
                    </div>

                    {{-- BBM --}}
                    <div class="mb-4">
                        <label class="label">Termasuk Biaya BBM?</label>
                        <select name="with_fuel" id="with_fuel" class="select select-bordered w-full" required>
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>

                    <div class="mb-4 hidden" id="fuel_days_wrapper">
                        <label class="label">Jumlah Hari untuk BBM</label>
                        <input type="number" name="fuel_days" id="fuel_days" class="input input-bordered w-full"
                            min="1" placeholder="Misal: 5">
                    </div>


                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Dokumen (KTP, SIM,
                            dll)</label>

                        <input id="documentInput" type="file" class="hidden" />
                        <button type="button" onclick="triggerFileInput()"
                            class="px-3 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm">Tambah Dokumen</button>

                        <div id="documentPreview" class="mt-3 space-y-2">
                            <!-- File list akan muncul di sini -->
                        </div>
                    </div>

                    {{-- Estimasi Biaya --}}
                    <div class="mb-4 bg-gray-100 p-4 rounded">
                        <p class="text-sm font-medium mb-1">Estimasi Total:</p>

                        {{-- Harga asli yang dicoret --}}
                        <p id="original_price_wrapper" class="text-sm text-gray-500 line-through mb-1"
                            style="display: none;">
                            Harga Asli: <span id="original_price">Rp 0</span>
                        </p>

                        {{-- Diskon --}}
                        <p class="text-sm text-gray-600 mb-1">Diskon: <span id="discount_amount"
                                class="font-semibold text-success">Rp 0</span></p>

                        {{-- Harga setelah diskon --}}
                        <p class="text-xl font-bold text-primary">Total Bayar: <span id="estimated_total">Rp 0</span>
                        </p>
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary w-full">Booking Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const carPrice12 = {{ $car->price_per_12_hours }};
        const carPrice24 = {{ $car->price_per_day }};
        const driverPricePerDay = 200000;
        const fuelPricePer3Days = 200000;

        const durationSelect = document.getElementById('duration_type');
        const customDaysWrapper = document.getElementById('custom_days_wrapper');
        const customDaysInput = document.getElementById('custom_days');

        const driverSelect = document.getElementById('driver_option');
        const driverDaysWrapper = document.getElementById('driver_days_wrapper');
        const driverDaysInput = document.getElementById('driver_days');

        const fuelSelect = document.getElementById('with_fuel');
        const fuelDaysWrapper = document.getElementById('fuel_days_wrapper');
        const fuelDaysInput = document.getElementById('fuel_days');

        const totalDisplay = document.getElementById('estimated_total');
        const discountDisplay = document.getElementById('discount_amount');
        const originalPriceDisplay = document.getElementById('original_price');
        const originalPriceWrapper = document.getElementById('original_price_wrapper');

        function calculateTotal() {
            const duration = durationSelect.value;
            const customDays = Math.max(parseInt(customDaysInput.value) || 0, 1);
            const driverValue = driverSelect.value;
            const fuelValue = fuelSelect.value;

            let base = 0;
            let discount = 0;
            let days = 1;

            if (duration === '12') {
                base = carPrice12;
                days = 0.5;
            } else if (duration === '24') {
                base = carPrice24;
                days = 1;
            } else if (duration === 'custom') {
                base = customDays * carPrice24;
                days = customDays;
                discount = Math.floor(customDays / 3) * 50000;
            }

            const driverDays = driverValue === '1' ? Math.max(parseInt(driverDaysInput.value) || 0, 1) : 0;
            const driverCost = driverDays * driverPricePerDay;

            const fuelDays = fuelValue === '1' ? Math.max(parseInt(fuelDaysInput.value) || 0, 1) : 0;
            const fuelCost = fuelDays * fuelPricePer3Days;

            const total = base - discount + driverCost + fuelCost;

            originalPriceDisplay.innerText = 'Rp ' + base.toLocaleString('id-ID');
            discountDisplay.innerText = 'Rp ' + discount.toLocaleString('id-ID');
            totalDisplay.innerText = 'Rp ' + total.toLocaleString('id-ID');

            originalPriceWrapper.style.display = discount > 0 ? 'block' : 'none';
        }

        durationSelect.addEventListener('change', () => {
            const isCustom = durationSelect.value === 'custom';
            customDaysWrapper.classList.toggle('hidden', !isCustom);
            customDaysInput.required = isCustom;
            if (!isCustom) customDaysInput.value = '';
            calculateTotal();
        });

        driverSelect.addEventListener('change', () => {
            const show = driverSelect.value === '1';
            driverDaysWrapper.classList.toggle('hidden', !show);
            driverDaysInput.required = show;
            if (!show) driverDaysInput.value = '';
            calculateTotal();
        });

        fuelSelect.addEventListener('change', () => {
            const show = fuelSelect.value === '1';
            fuelDaysWrapper.classList.toggle('hidden', !show);
            fuelDaysInput.required = show;
            if (!show) fuelDaysInput.value = '';
            calculateTotal();
        });

        [customDaysInput, driverDaysInput, fuelDaysInput].forEach(el => {
            el.addEventListener('input', calculateTotal);
            el.addEventListener('change', calculateTotal);
        });

        // Initial calculation
        calculateTotal();
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

</x-guest-layout>
