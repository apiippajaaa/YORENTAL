<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Daftar Penyewaan Mobil') }}
            </h2>
            <a href="{{ route('car_rentals.create') }}"
                class="w-full md:w-auto inline-flex items-center rounded-md border border-red-300 bg-red-500 px-4 py-2 text-sm font-semibold shadow-sm hover:bg-red-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 text-white">
                Sewa Offline
            </a>
        </div>
    </x-slot>

    <div class="w-full px-4 py-1">
        {{-- Filter & Search Form --}}
        <form method="GET" action="{{ route('car_rentals.index') }}"
            class="mb-6 bg-white p-6 rounded-md shadow space-y-6">

            <div class="md:hidden">
                <button type="button" id="toggleFilterBtn"
                    class="w-full px-4 py-2 bg-red-600 text-white rounded-md font-semibold hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 flex gap-2 justify-center items-center">
                    <i class="fa-solid fa-filter"></i> <span>Filter</span>
                </button>
            </div>

            {{-- Form filter, hidden di mobile default --}}
            <div id="filterFormContent" class="hidden md:grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Nama User --}}
                <div>
                    <label for="user_name" class="block text-sm font-medium text-gray-700">Nama Pengguna</label>
                    <input type="text" id="user_name" name="user_name" value="{{ request('user_name') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>

                {{-- Nama Mobil --}}
                <div>
                    <label for="car_name" class="block text-sm font-medium text-gray-700">Nama Mobil</label>
                    <input type="text" id="car_name" name="car_name" value="{{ request('car_name') }}"
                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500">
                </div>

                {{-- Filter Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" id="status"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring focus:ring-red-200 focus:ring-opacity-50">
                        <option value="">Semua</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui
                        </option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan
                        </option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai
                        </option>
                    </select>
                </div>

                {{-- Button Reset + Submit --}}
                <div class="w-full flex flex-row justify-end items-center gap-2 mt-6">
                    <a href="{{ route('car_rentals.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400">
                        Reset
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Filter
                    </button>
                </div>
            </div>
        </form>

        <script>
            // Toggle form filter di mobile
            document.getElementById('toggleFilterBtn').addEventListener('click', function() {
                const filterContent = document.getElementById('filterFormContent');
                if (filterContent.classList.contains('hidden')) {
                    filterContent.classList.remove('hidden');
                } else {
                    filterContent.classList.add('hidden');
                }
            });
        </script>


        {{-- Tabel Penyewaan Mobil --}}
        <div class="overflow-x-auto bg-white rounded-lg shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-500 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-medium">No</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Nama Pengguna</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Mobil</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Tanggal Mulai</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Tanggal Selesai</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Durasi</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Total</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($rentals as $index => $rental)
                        <tr>
                            <td class="px-4 py-3">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3">{{ $rental->user->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $rental->car->name ?? '-' }}</td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($rental->start_date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($rental->end_date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3">
                                @if ($rental->duration_type === '12' || $rental->duration_type === '24')
                                    {{ $rental->duration_type }} jam
                                @elseif ($rental->duration_type === 'custom')
                                    {{ $rental->custom_duration }} hari
                                @else
                                    Tidak diketahui
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $isCustom = $rental->duration_type === 'custom';
                                    $customDays = $rental->custom_duration ?? 0;
                                    $carPrice = $rental->car->price_per_day ?? 0;
                                    $originalPrice = $isCustom ? $customDays * $carPrice : null;
                                    $discount = $isCustom ? floor($customDays / 3) * 50000 : 0;
                                @endphp

                                @if ($discount > 0 && $originalPrice)
                                    <div class="text-xs text-gray-400 line-through">
                                        Rp{{ number_format($originalPrice, 0, ',', '.') }}</div>
                                    <div class="text-sm font-semibold text-green-600">
                                        Rp{{ number_format($rental->total_price, 0, ',', '.') }}</div>
                                    <div class="text-xs text-success">Diskon
                                        Rp{{ number_format($discount, 0, ',', '.') }}</div>
                                @else
                                    <div class="text-sm font-semibold text-gray-800">
                                        Rp{{ number_format($rental->total_price, 0, ',', '.') }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <span
                                    class="
                                    inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                    @if ($rental->status === 'menunggu_konfirmasi') bg-orange-300 text-orange-800
                                    @elseif($rental->status === 'booked') bg-yellow-300 text-yellow-800
                                    @elseif($rental->status === 'on_rent') bg-blue-300 text-blue-800
                                    @elseif($rental->status === 'selesai') bg-green-300 text-green-800
                                    @elseif($rental->status === 'dibatalkan') bg-red-300 text-red-800
                                    @elseif($rental->status === 'ditolak') bg-gray-300 text-gray-700
                                    @else bg-gray-200 text-gray-600 @endif
                                ">
                                    {{ ucwords(str_replace('_', ' ', $rental->status)) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 flex gap-2 justify-center items-center">
                                <a href="{{ route('car_rentals.show', $rental->id) }}"
                                    class="text-white hover:bg-green-900 bg-green-500 p-2 rounded-md flex justify-center items-center">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('car_rentals.edit', $rental->id) }}"
                                    class="text-white hover:bg-blue-900 bg-blue-500 p-2 rounded-md flex justify-center items-center">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('car_rentals.destroy', $rental->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-white hover:bg-red-900 bg-red-500 p-2 rounded-md flex justify-center items-center">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-6 text-gray-500">Belum ada data penyewaan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $rentals->withQueryString()->links() }}
        </div>
    </div>
</x-app-layout>
