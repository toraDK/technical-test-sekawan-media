<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogHelper;
use App\Models\Booking;
use App\Models\BookingApproval;
use App\Models\Driver;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Exports\BookingsExport;
use Maatwebsite\Excel\Facades\Excel;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['vehicle', 'driver', 'admin', 'approvals.approver'])
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $vehicles  = Vehicle::where('status', 'available')->get();
        $drivers   = Driver::where('status', 'available')->get();
        $approvers = User::where('role', 'approver')->get();

        return view('bookings.create', compact('vehicles', 'drivers', 'approvers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_id'   => 'required|exists:vehicles,id',
            'driver_id'    => 'required|exists:drivers,id',
            'approver_1'   => 'required|exists:users,id',
            'approver_2'   => 'required|exists:users,id|different:approver_1',
            'start_date'   => 'required|date|after_or_equal:today',
            'end_date'     => 'required|date|after:start_date',
            'purpose'      => 'required|string|max:500',
        ], [
            'approver_2.different' => 'Penyetujui Level 2 harus berbeda dengan Penyetujui Level 1.',
        ]);

        DB::beginTransaction();
        try {
            $actorName = Auth::user()?->name ?? 'System';

            // 1. Buat Record Booking
            $bookingCode = 'NKL-BOOK-' . strtoupper(Str::random(6));
            $booking = Booking::create([
                'booking_code' => $bookingCode,
                'admin_id'     => Auth::id(),
                'vehicle_id'   => $request->vehicle_id,
                'driver_id'    => $request->driver_id,
                'start_date'   => $request->start_date,
                'end_date'     => $request->end_date,
                'purpose'      => $request->purpose,
                'status'       => 'pending',
            ]);

            // 2. Buat Approval Level 1
            BookingApproval::create([
                'booking_id'  => $booking->id,
                'approver_id' => $request->approver_1,
                'level'       => 1,
                'status'      => 'pending',
            ]);

            // 3. Buat Approval Level 2
            BookingApproval::create([
                'booking_id'  => $booking->id,
                'approver_id' => $request->approver_2,
                'level'       => 2,
                'status'      => 'pending',
            ]);

            // 4. Catat Activity Log
            ActivityLogHelper::log(
                'CREATE_BOOKING',
                "Admin {$actorName} membuat pemesanan kendaraan [{$bookingCode}]."
            );

            DB::commit();

            return redirect()->route('bookings.index')
                ->with('success', 'Pemesanan kendaraan berhasil diajukan dan menunggu persetujuan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pemesanan: ' . $e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new BookingsExport, 'daftar-pemesanan-kendaraan_' . date('Y-m-d') . '.xlsx');
    }
}