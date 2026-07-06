<?php

use App\Http\Controllers\Backend\CarCategoryController;
use App\Http\Controllers\Backend\CarController;
use App\Http\Controllers\Backend\CarPhotoController;
use App\Http\Controllers\Backend\CarRentalController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Frontend\CarBookingController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\FaqController;
use App\Http\Controllers\Frontend\FrontendProfileController;
use App\Http\Controllers\Frontend\HomeCarouselController;
use App\Http\Controllers\Frontend\LinkController;
use App\Http\Controllers\Frontend\TestimonialController;
use App\Http\Controllers\ProfileController;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarRental;
use App\Models\faq;
use App\Models\link;
use App\Models\HomeCarousel;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('maintenance');
// });

Route::get('/', function () {
    return view('pages.frontend.homepage', [
        'homecarousels' => HomeCarousel::all(),
        'cars' => Car::with(['photos'])
            ->withCount('rentals')
            ->orderByDesc('rentals_count')
            ->limit(8)
            ->get(),
        'testimonials' => Testimonial::all(),
        'faqs' => faq::all(),
        'links' => link::all()

    ]);
});

route::get('/cars', function () {
    return view('pages.frontend.cars.index', [
        'cars' => Car::with('photos')->get(),
    ]);
})->name('frontend.cars');

Route::get('/cars/{car}', function (Car $car) {
    $car->load('photos', 'category');
    return view('pages.frontend.cars.show', compact('car'));
})->name('frontend.cars.show');

Route::get('/contact', function () {
    return view('pages.frontend.contact.index', [
        'links' => link::all()
    ]);
})->name('contact-us');


Route::post('/contact/send', [ContactController::class, 'send'])->name('contact.send');

Route::view('/kebijakan-privasi', 'pages.frontend.dokumen.kebijakan-privasi')->name('privacy');
Route::view('/syarat-dan-ketentuan', 'pages.frontend.dokumen.syarat-ketentuan')->name('terms');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [FrontendProfileController::class, 'edit'])->name('frontend.profile.edit');
    Route::patch('/profile', [FrontendProfileController::class, 'update'])->name('frontend.profile.update');

    Route::get('cars/booking/create', [CarBookingController::class, 'create'])->name('booking.create');
    Route::post('cars/booking', [CarBookingController::class, 'store'])->name('booking.store');
    Route::get('cars/booking/status', [CarBookingController::class, 'status'])->name('booking.status');
});


Route::group(
    [
        'middleware' => ['auth', 'admin'],
        'prefix' => 'admin'
    ],
    function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('car-categories', CarCategoryController::class);

        Route::resource('cars', CarController::class);
        Route::put('/cars/{car}/photos/{photo}', [CarPhotoController::class, 'updatePhoto'])->name('cars.photos.update');
        Route::delete('/cars/{car}/photos/{photo}', [CarPhotoController::class, 'destroyPhoto'])->name('cars.photos.destroy');
        Route::resource('car_rentals', CarRentalController::class);

        Route::get('/personalize', function () {
            return view('pages.backend.personalize.index');
        })->name('personalize.index');
        Route::resource('personalize/home-carousel', HomeCarouselController::class);
        Route::resource('personalize/testimonials', TestimonialController::class);
        Route::resource('personalize/faqs', FaqController::class);
        Route::resource('personalize/links', LinkController::class);


        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        route::resource('users', UserController::class);
    }
);

require __DIR__ . '/auth.php';
