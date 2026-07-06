<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-row sm:items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>

        </div>
    </x-slot>
    <div>
        <h1 class="mt-2  text-slate-600 text-2xl">
            Hai, {{ Auth::user()->name }} 👋
        </h1>
        <p class="text-indigo-700 text-sm italic">"Semangat hari ini! Jangan lupa istirahat dan tetap produktif 💪"
        </p>
    </div>
    <div class="space-y-4 mt-8">
        <div class="">
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-white rounded-md shadow-md p-4">
                    <h1 class="text-gray-600 text-sm mb-1">Total Kategori Mobil</h1>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalCategories }}</p>
                </div>
                <div class="bg-white rounded-md shadow-md p-4">
                    <h1 class="text-gray-600 text-sm mb-1">Total Mobil</h1>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalCars }}</p>
                </div>
                <div class="bg-white rounded-md shadow-md p-4">
                    <h1 class="text-gray-600 text-sm mb-1">Total Booking</h1>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalBookings }}</p>
                </div>
                <div class="bg-white rounded-md shadow-md p-4">
                    <h1 class="text-gray-600 text-sm mb-1">Total Pengguna</h1>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
        <div class="">
            <div class="bg-white p-4 rounded-md shadow-md">
                <h3 class="text-lg font-semibold mb-4">Jadwal Booking Hari Ini</h3>

                @forelse ($todaysBookings as $booking)
                    <div class="border-b py-2 flex justify-between items-center text-sm">
                        <div>
                            <strong>{{ $booking->nama ?? $booking->user->name }}</strong>
                            <p class="text-gray-600">
                                Mobil: {{ $booking->car->name ?? '-' }}<br>
                                Jam: {{ \Carbon\Carbon::parse($booking->start_date)->format('H:i') }} WIB
                            </p>
                        </div>
                        <span
                            class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700 capitalize">{{ $booking->status }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Belum ada booking hari ini.</p>
                @endforelse
            </div>
        </div>
        <div class="mt-10 space-y-4">
            <div class="bg-white rounded-md shadow-md p-4 ">
                <h1>Pendapatan Bulan Ini</h1>
                <p>Rp {{ number_format($monthlyRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                <div class="bg-white rounded-md shadow-md p-4">
                    <h1>Booking Minggu Ini</h1>
                    <p>{{ $bookingsThisWeek }}</p>
                </div>
                <div class="bg-white rounded-md shadow-md p-4">
                    <h1>Booking Bulan Ini</h1>
                    <p>{{ $bookingsThisMonth }}</p>
                </div>
                <div class="bg-white rounded-md shadow-md p-4">
                    <h1>Dibatalkan / Ditolak</h1>
                    <p>{{ $cancelledOrRejected }}</p>
                </div>
                <div class="bg-white rounded-md shadow-md p-4">
                    <h1>Booking Aktif</h1>
                    <p>{{ $activeBookings }}</p>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
