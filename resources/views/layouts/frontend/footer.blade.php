<footer class="footer footer-horizontal footer-center text-white rounded p-10 bg-red-500 mt-8">
    @php
        $navLinks = [
            ['label' => 'Daftar Mobil', 'route' => route('frontend.cars')],
            ['label' => 'Hubungi Kami', 'route' => route('contact-us')],
            ['label' => 'Kebijakan Privasi', 'route' => route('privacy')],
            ['label' => 'Syarat dan Ketentuan', 'route' => route('terms')],
        ];
    @endphp

    <nav class="grid grid-flow-col gap-4">
        @foreach ($navLinks as $link)
            <a href="{{ $link['route'] }}" class="link link-hover" target="_blank">{{ $link['label'] }}</a>
        @endforeach
    </nav>

    <nav>
        <div class="grid grid-flow-col gap-8 text-xl">
            <a href="https://wa.me/your_number" target="_blank" class="text-white">
                <i class="fab fa-whatsapp"></i>
            </a>
            <a href="https://instagram.com/your_username" target="_blank" class="text-white">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="https://facebook.com/your_page" target="_blank" class="text-white">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="https://www.tiktok.com/@your_username" target="_blank" class="text-white">
                <i class="fab fa-tiktok"></i>
            </a>
        </div>

    </nav>
    <aside>
        <p>&copy; {{ date('Y') }} - All rights reserved by YoRental.</p>
    </aside>
</footer>
