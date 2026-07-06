<x-guest-layout>
    @section('banner')
        <div class="relative w-full h-32 md:h-64 overflow-hidden mb-2 shadow-md">
            <img src="{{ asset('assets/banner/profile-banner.jpg') }}" alt="Banner" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black bg-opacity-60 flex items-center justify-center">
                <h1 class="text-white text-2xl md:text-5xl font-semibold drop-shadow-lg">Update Profil</h1>
            </div>
        </div>
    @endsection

    <div class="py-4 md:py-12">
        <div class="w-full flex flex-col md:flex-row gap-8">
            <div
                class="w-full p-4 sm:p-8 bg-white shadow-[0px_0px_0px_1px_rgba(0,0,0,0.06),0px_1px_1px_-0.5px_rgba(0,0,0,0.06),0px_3px_3px_-1.5px_rgba(0,0,0,0.06),_0px_6px_6px_-3px_rgba(0,0,0,0.06),0px_12px_12px_-6px_rgba(0,0,0,0.06),0px_24px_24px_-12px_rgba(0,0,0,0.06)] sm:rounded-lg">
                <div class="">
                    @include('pages.frontend.profile.partials.update-profile-information-form')
                </div>
            </div>

            <div
                class="w-full p-4 sm:p-8 bg-white shadow-[0px_0px_0px_1px_rgba(0,0,0,0.06),0px_1px_1px_-0.5px_rgba(0,0,0,0.06),0px_3px_3px_-1.5px_rgba(0,0,0,0.06),_0px_6px_6px_-3px_rgba(0,0,0,0.06),0px_12px_12px_-6px_rgba(0,0,0,0.06),0px_24px_24px_-12px_rgba(0,0,0,0.06)] sm:rounded-lg">
                <div class="">
                    @include('pages.frontend.profile.partials.update-password-form')
                </div>
            </div>


        </div>
    </div>
</x-guest-layout>
