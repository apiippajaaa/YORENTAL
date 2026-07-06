<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\CarCategory;
use App\Models\CarRental;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalCategories = CarCategory::count();
        $totalCars = Car::count();
        $totalBookings = CarRental::count();
        $totalUsers = User::count();

        $startOfWeek = Carbon::now()->startOfWeek();
        $startOfMonth = Carbon::now()->startOfMonth();

        $bookingsThisWeek = CarRental::where('start_date', '>=', $startOfWeek)->count();
        $bookingsThisMonth = CarRental::where('start_date', '>=', $startOfMonth)->count();

        $cancelledOrRejected = CarRental::whereIn('status', ['dibatalkan', 'ditolak'])->count();
        $activeBookings = CarRental::whereIn('status', ['booked', 'on_rent'])->count();

        $monthlyRevenue = CarRental::whereMonth('start_date', now()->month)->sum('total_price');


        $todaysBookings = CarRental::whereDate('start_date', now())->get();

        return view('pages.backend.dashboard', compact(
            'totalCategories',
            'totalCars',
            'totalBookings',
            'totalUsers',
            'bookingsThisWeek',
            'bookingsThisMonth',
            'cancelledOrRejected',
            'activeBookings',
            'monthlyRevenue',
            'todaysBookings'
        ));
    }
}
