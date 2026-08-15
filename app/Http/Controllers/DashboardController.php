<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
// use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $approvedBookings = Booking::where('status', 'approved')->count();
        $totalVehicles = Vehicle::count();

        $recentBookings = Booking::with(['vehicle', 'driver'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBookings',
            'pendingBookings',
            'approvedBookings',
            'totalVehicles',
            'recentBookings'
        ));
    }
}
