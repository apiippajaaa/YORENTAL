<x-guest-layout>
    <div class="max-w-3xl mx-auto px-6 py-10 text-gray-800">
        <h1 class="text-4xl font-bold mb-6 text-center">Syarat & Ketentuan</h1>

        <p class="mb-4">Dengan menggunakan layanan rental mobil dari <strong>{{ config('app.name') }}</strong>, Anda
            dianggap telah membaca, memahami, dan menyetujui semua syarat dan ketentuan yang berlaku.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">1. Pemesanan & Pembayaran</h2>
        <ul class="list-disc list-inside mb-4 space-y-1">
            <li>Pemesanan dapat dilakukan secara online atau offline</li>
            <li>Pembayaran dilakukan di awal atau sesuai kesepakatan</li>
            <li>Harga dapat berubah sewaktu-waktu tanpa pemberitahuan</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-6 mb-2">2. Syarat Penyewa</h2>
        <ul class="list-disc list-inside mb-4 space-y-1">
            <li>Usia minimal 20 tahun</li>
            <li>Memiliki SIM yang masih berlaku</li>
            <li>Menyerahkan identitas asli (KTP/SIM/NPWP/Dokumen Identitas Resmi Lain)</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-6 mb-2">3. Penggunaan Kendaraan</h2>
        <ul class="list-disc list-inside mb-4 space-y-1">
            <li>Tidak digunakan untuk kegiatan ilegal</li>
            <li>Penyewa bertanggung jawab atas kerusakan selama masa sewa</li>
            <li>BBM dan denda keterlambatan ditanggung penyewa</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-6 mb-2">4. Pembatalan</h2>
        <p class="mb-4">Pembatalan sewa dikenakan biaya administrasi. Dana yang sudah dibayarkan tidak dapat
            dikembalikan sepenuhnya, kecuali dalam kondisi tertentu yang disepakati.</p>

        <p class="mt-6 text-sm text-gray-600">Terakhir diperbarui: {{ now()->format('d F Y') }}</p>
    </div>
</x-guest-layout>
