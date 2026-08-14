<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogHelper;
use App\Models\Booking;
use App\Models\BookingApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    /**
     * Menampilkan daftar pengajuan booking yang perlu disetujui oleh user yang login.
     */
    public function index()
    {
        $userId = Auth::id();

        // Ambil approval yang ditugaskan ke user login
        $approvals = BookingApproval::with(['booking.vehicle', 'booking.driver', 'booking.admin'])
            ->where('approver_id', $userId)
            ->latest()
            ->paginate(10);

        return view('approvals.index', compact('approvals'));
    }

    /**
     * Memproses Persetujuan (Approve) atau Penolakan (Reject).
     */
    public function process(Request $request, $id)
    {
        $request->validate([
            'action' => 'required|in:approved,rejected',
            'note'   => 'nullable|string|max:255',
        ]);

        $approval = BookingApproval::where('id', $id)
            ->where('approver_id', Auth::id())
            ->firstOrFail();

        $booking = $approval->booking;

        // Validasi: Level 2 tidak bisa memproses jika Level 1 belum menyetujui
        if ($approval->level == 2) {
            $level1 = BookingApproval::where('booking_id', $booking->id)
                ->where('level', 1)
                ->first();

            if ($level1 && $level1->status !== 'approved') {
                return back()->with('error', 'Penyetujui Level 1 belum menyetujui pemesanan ini.');
            }
        }

        DB::beginTransaction();
        try {
            // Update status approval
            $approval->update([
                'status' => $request->action,
                'note'   => $request->note,
            ]);

            $approverName = Auth::user()->name;
            $actionText = $request->action == 'approved' ? 'menyetujui' : 'menolak';

            // Catat activity log
            ActivityLogHelper::log(
                'APPROVAL_ACTION',
                "Penyetujui Lvl {$approval->level} ({$approverName}) {$actionText} pemesanan [{$booking->booking_code}]."
            );

            // Cek kondisi status utama Booking
            if ($request->action == 'rejected') {
                // Jika salah satu menolak, booking langsung REJECTED
                $booking->update(['status' => 'rejected']);
            } else {
                // Cek apakah semua level sudah menyetujui
                $allApproved = BookingApproval::where('booking_id', $booking->id)
                    ->where('status', '!=', 'approved')
                    ->doesntExist();

                if ($allApproved) {
                    $booking->update(['status' => 'approved']);
                }
            }

            DB::commit();

            return redirect()->route('approvals.index')
                ->with('success', "Berhasil {$actionText} pengajuan pemesanan.");
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses persetujuan: ' . $e->getMessage());
        }
    }
}