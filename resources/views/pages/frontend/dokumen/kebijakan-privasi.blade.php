<x-guest-layout>
    <div class="max-w-3xl mx-auto px-6 py-10 text-gray-800">
        <h1 class="text-4xl font-bold mb-6 text-center">Kebijakan Privasi</h1>

        <p class="mb-4">Kami di <strong>{{ config('app.name') }}</strong> sangat menghargai privasi Anda. Halaman ini
            menjelaskan bagaimana kami mengelola dan melindungi informasi pribadi Anda saat menggunakan layanan rental
            mobil kami.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">1. Informasi yang Kami Kumpulkan</h2>
        <ul class="list-disc list-inside mb-4 space-y-1">
            <li>Nama lengkap dan kontak (email, nomor HP)</li>
            <li>Detail pemesanan & riwayat transaksi</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-6 mb-2">2. Cara Kami Menggunakan Informasi Anda</h2>
        <ul class="list-disc list-inside mb-4 space-y-1">
            <li>Untuk memproses dan mengelola pemesanan</li>
            <li>Memberikan informasi layanan atau promo</li>
            <li>Menjaga keamanan dan kenyamanan layanan</li>
        </ul>

        <h2 class="text-2xl font-semibold mt-6 mb-2">3. Keamanan Data</h2>
        <p class="mb-4">Kami menggunakan sistem yang aman untuk melindungi data Anda dari akses yang tidak sah. Kami
            tidak membagikan informasi pribadi Anda ke pihak ketiga tanpa izin Anda.</p>

        <h2 class="text-2xl font-semibold mt-6 mb-2">4. Perubahan Kebijakan</h2>
        <p class="mb-4">Kebijakan ini dapat berubah sewaktu-waktu. Kami sarankan Anda untuk memeriksa halaman ini
            secara berkala.</p>

        <p class="mt-6 text-sm text-gray-600">Terakhir diperbarui: {{ now()->format('d F Y') }}</p>
    </div>
</x-guest-layout>
