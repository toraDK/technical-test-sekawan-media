@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Daftar Pemesanan Kendaraan</h3>
        <a href="{{ route('bookings.create') }}" class="btn btn-primary">+ Tambah Pemesanan</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Kode</th>
                        <th>Kendaraan</th>
                        <th>Driver</th>
                        <th>Tanggal Pemakaian</th>
                        <th>Penyetujui Lvl 1</th>
                        <th>Penyetujui Lvl 2</th>
                        <th>Status Booking</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                        @php
                            $lvl1 = $booking->approvals->where('level', 1)->first();
                            $lvl2 = $booking->approvals->where('level', 2)->first();
                        @endphp
                        <tr>
                            <td><strong>{{ $booking->booking_code }}</strong></td>
                            <td>{{ $booking->vehicle->name }} ({{ $booking->vehicle->license_plate }})</td>
                            <td>{{ $booking->driver->name }}</td>
                            <td>{{ $booking->start_date }} s/d {{ $booking->end_date }}</td>
                            <td>
                                {{ $lvl1?->approver?->name ?? '-' }}
                                <br>
                                <span class="badge bg-{{ $lvl1?->status == 'approved' ? 'success' : ($lvl1?->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($lvl1?->status ?? 'pending') }}
                                </span>
                            </td>
                            <td>
                                {{ $lvl2?->approver?->name ?? '-' }}
                                <br>
                                <span class="badge bg-{{ $lvl2?->status == 'approved' ? 'success' : ($lvl2?->status == 'rejected' ? 'danger' : 'warning') }}">
                                    {{ ucfirst($lvl2?->status ?? 'pending') }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $booking->status == 'approved' ? 'success' : ($booking->status == 'rejected' ? 'danger' : 'secondary') }}">
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">Belum ada pemesanan kendaraan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $bookings->links() }}
        </div>
    </div>
</div>
@endsection