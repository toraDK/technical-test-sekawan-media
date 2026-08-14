<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogHelper;
use App\Models\BookingApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    /**
     * Menampilkan daftar antrean approval untuk user yang sedang login
     */
    public function index()
    {
        $approvals = BookingApproval::with(['booking.vehicle', 'booking.driver', 'booking.admin'])
            ->where('approver_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('approvals.index', compact('approvals'));
    }

    /**
     * Memproses Persetujuan / Penolakan Berjenjang
     */
    public function process(Request $request, $id)
    {
        $actorName = Auth::user()?->name ?? 'System';

        $request->validate([
            'action' => 'required|in:approved,rejected',
            'notes'  => 'nullable|string|max:255',
        ]);

        $approval = BookingApproval::with('booking')->findOrFail($id);

        // Keamanan: Cek apakah user yang login benar-benar approver yang ditunjuk
        if ($approval->approver_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak berhak memproses persetujuan ini.');
        }

        // Cek jika status approval ini sudah diproses sebelumnya
        if ($approval->status !== 'pending') {
            return back()->with('error', 'Persetujuan ini sudah pernah diproses.');
        }

        // Validasi Berjenjang: Level 2 TIDAK BISA diproses jika Level 1 belum Approved
        if ($approval->level == 2) {
            $level1 = BookingApproval::where('booking_id', $approval->booking_id)
                ->where('level', 1)
                ->first();

            if (!$level1 || $level1->status !== 'approved') {
                return back()->with('error', 'Persetujuan Level 1 harus disetujui terlebih dahulu.');
            }
        }

        DB::beginTransaction();
        try {
            $booking = $approval->booking;

            // Update status record approval saat ini
            $approval->update([
                'status'    => $request->action,
                'notes'     => $request->notes,
                'action_at' => now(),
            ]);

            if ($request->action === 'rejected') {
                // JIKA REJECTED: Otomatis membatalkan pemesanan secara keseluruhan
                $booking->update(['status' => 'rejected']);

                ActivityLogHelper::log(
                    'REJECT_BOOKING',
                    "User {$actorName} MENOLAK pemesanan [{$booking->booking_code}] pada Level {$approval->level}. Alasan: " . ($request->notes ?? '-')
                );
            } else {
                // JIKA APPROVED
                if ($approval->level == 1) {
                    // Update status booking ke partially_approved
                    $booking->update(['status' => 'partially_approved']);

                    ActivityLogHelper::log(
                        'APPROVE_LEVEL_1',
                        "User {$actorName} MENYETUJUI pemesanan [{$booking->booking_code}] (Level 1)."
                    );
                } elseif ($approval->level == 2) {
                    // Level 2 Approved -> Pemesanan Resmi Disetujui Sepenuhnya
                    $booking->update(['status' => 'approved']);

                    // Update status kendaraan menjadi 'in_use'
                    $booking->vehicle()->update(['status' => 'in_use']);

                    ActivityLogHelper::log(
                        'APPROVE_LEVEL_2',
                        "User {$actorName} MENYETUJUI pemesanan [{$booking->booking_code}] (Level 2 Final). Status kendaraan diubah menjadi 'in_use'."
                    );
                }
            }

            DB::commit();

            return redirect()->route('approvals.index')
                ->with('success', 'Status pemesanan berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memproses persetujuan: ' . $e->getMessage());
        }
    }
}