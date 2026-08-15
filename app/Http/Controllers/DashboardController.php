<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use Carbon\Carbon;
// use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $approvedBookings = Booking::where('status', 'approved')->count();
        $totalVehicles = Vehicle::count();

        $startMonth = Carbon::now()->startOfMonth()->subMonths(5);
        $monthlyUsage = collect(range(0, 5))->mapWithKeys(function ($index) use ($startMonth) {
            $month = (clone $startMonth)->addMonths($index);

            return [$month->format('Y-m') => 0];
        });

        $bookingUsage = Booking::whereNotNull('start_date')
            ->whereDate('start_date', '>=', $startMonth->toDateString())
            ->get(['start_date'])
            ->groupBy(function ($booking) {
                return Carbon::parse($booking->start_date)->format('Y-m');
            })
            ->map->count();

        $monthlyUsage = $monthlyUsage->merge($bookingUsage);
        $usageChartLabels = $monthlyUsage->keys()
            ->map(fn ($month) => Carbon::createFromFormat('Y-m', $month)->translatedFormat('M Y'))
            ->values();
        $usageChartData = $monthlyUsage->values();

        $recentBookings = Booking::with(['vehicle', 'driver'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalBookings',
            'pendingBookings',
            'approvedBookings',
            'totalVehicles',
            'usageChartLabels',
            'usageChartData',
            'recentBookings'
        ));
    }
}
