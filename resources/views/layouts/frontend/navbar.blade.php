<div class="navbar bg-base-100 shadow-sm px-0 md:px-8">

    {{-- MOBILE --}}
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li><a href="{{ route('frontend.cars') }}">Daftar Mobil</a></li>
                {{-- <li>
                    <a>Parent</a>
                    <ul class="p-2">
                        <li><a>Submenu 1</a></li>
                        <li><a>Submenu 2</a></li>
                    </ul>
                </li> --}}
                <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
            </ul>
        </div>
        <a class="btn btn-ghost text-xl" href="/">{{ config('app.name') }}</a>
    </div>
    {{-- DESKTOP --}}
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal ">
            <li><a href="{{ route('frontend.cars') }}">Daftar Mobil</a></li>
            {{-- <li>
                <details>
                    <summary>Parent</summary>
                    <ul class="p-2">
                        <li><a>Submenu 1</a></li>
                        <li><a>Submenu 2</a></li>
                    </ul>
                </details>
            </li> --}}
            <li><a href="{{ route('contact-us') }}">Contact Us</a></li>
        </ul>
    </div>
    <div class="navbar-end">
        @auth
            <div class="dropdown dropdown-end">
                <label tabindex="0" class="btn btn-ghost">
                    {{ Auth::user()->name }}
                    <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </label>
                <ul tabindex="0" class="menu dropdown-content mt-2 p-2 shadow bg-base-100 rounded-box w-52">
                    <li>
                        <a href="{{ route('frontend.profile.edit') }}">Profile</a>

                    </li>
                    <li>
                        <a href="{{ route('booking.status') }}">Status Booking</a>

                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="text-red-600">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" class="btn btn-ghost">Masuk</a>
            <a href="{{ route('register') }}" class="btn btn-ghost">Daftar</a>
        @endauth
    </div>

</div>
