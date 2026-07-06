<x-guest-layout>
    @section('banner')
        <div class="relative w-full h-32 md:h-64 overflow-hidden mb-2 shadow-md">
            <img src="{{ asset('assets/banner/booking-list.jpg') }}" alt="Banner" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                <h1 class="text-white text-2xl md:text-5xl font-semibold drop-shadow-lg">Daftar Booking Anda</h1>
            </div>
        </div>
    @endsection
    <div class="w-full mx-auto py-12 px-4">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @forelse ($rentals as $rental)
                <div
                    class="border-l-4 border-error bg-gray-50 hover:bg-gray-100 transition duration-300 rounded-r-xl shadow-[0px_0px_5px_0px_#718096] p-5 mb-5 group">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 group-hover:text-primary">
                                {{ $rental->car->name }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                <strong>Tanggal Mulai:</strong>
                                {{ \Carbon\Carbon::parse($rental->start_date)->format('d F Y') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <strong>Tanggal Selesai:</strong>
                                {{ \Carbon\Carbon::parse($rental->end_date)->format('d F Y') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <strong>Status:</strong>
                                <span class="font-medium text-success">
                                    {{ ucwords(str_replace('_', ' ', $rental->status)) }}</span>
                            </p>
                        </div>

                        {{-- <div class="mt-3 sm:mt-0">
                        <a href="{{ route('rentals.show', $rental->id) }}"
                            class="inline-block text-sm font-medium text-primary hover:underline">
                            Lihat Detail →
                        </a>
                    </div> --}}
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    <p class="text-lg">Belum ada booking yang tercatat.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-guest-layout>
