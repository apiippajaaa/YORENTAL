<div
    class="relative flex w-72 flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-[0_3px_10px_rgb(0,0,0,0.2)] mt-8">
    <div
        class="relative mx-4 -mt-6 h-40 overflow-hidden rounded-xl bg-red-gray-500 bg-clip-border text-white shadow-lg shadow-red-gray-500/40 bg-gradient-to-r from-red-500 to-red-600">
        <img src="{{ $image }}" alt="">
    </div>
    <div class="p-6">
        <h5
            class="mb-2 block font-sans text-xl font-semibold leading-snug tracking-normal text-blue-gray-900 antialiased">
            {{ $title }}
        </h5>
        <p class="block font-sans text-base font-light leading-relaxed text-inherit antialiased">
            {{ $description }}
        </p>
    </div>
    <div class="p-6 pt-0 w-full flex justify-center">
        <button data-ripple-light="true" type="button"
            class="select-none rounded-lg bg-green-500 py-3 px-6 text-center align-middle font-sans text-xs font-bold uppercase text-white shadow-md shadow-green-500/20 transition-all hover:shadow-lg hover:shadow-green-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none flex gap-2 items-center">
            <i class="fa-solid {{ $buttonIcon }}"></i>
            <p>{{ $buttonText }}</p>
        </button>
    </div>
</div>
