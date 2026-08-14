@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Daftar Persetujuan Pemesanan</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Pemohon (Admin)</th>
                        <th>Kendaraan</th>
                        <th>Driver</th>
                        <th>Tanggal Pemakaian</th>
                        <th>Level Anda</th>
                        <th>Status Saat Ini</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($approvals as $item)
                        <tr>
                            <td><strong>{{ $item->booking->booking_code }}</strong></td>
                            <td>{{ $item->booking->admin->name }}</td>
                            <td>{{ $item->booking->vehicle->name }} ({{ $item->booking->vehicle->license_plate }})</td>
                            <td>{{ $item->booking->driver->name }}</td>
                            <td>{{ $item->booking->start_date }} s/d {{ $item->booking->end_date }}</td>
                            <td><span class="badge bg-info text-dark">Level {{ $item->level }}</span></td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'approved' ? 'success' : ($item->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td>
                                @if($item->status == 'pending')
                                    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalApprove{{ $item->id }}">
                                        Proses
                                    </button>

                                    <!-- Modal Approval -->
                                    <div class="modal fade" id="modalApprove{{ $item->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('approvals.process', $item->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Persetujuan Booking [{{ $item->booking->booking_code }}]</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Tujuan Pemakaian:</strong> {{ $item->booking->purpose }}</p>
                                                        <div class="mb-3">
                                                            <label class="form-label">Catatan / Alasan (Opsional)</label>
                                                            <textarea name="note" class="form-control" rows="2" placeholder="Masukkan catatan..."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" name="action" value="rejected" class="btn btn-danger">Tolak</button>
                                                        <button type="submit" name="action" value="approved" class="btn btn-success">Setujui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted"><small>Selesai</small></span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">Belum ada pengajuan yang membutuhkan persetujuan Anda.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $approvals->links() }}
        </div>
    </div>
</div>
@endsection