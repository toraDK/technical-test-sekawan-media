@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    
    {{-- Header Section --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">Dashboard Operasional</h1>
            <p class="mt-1 text-sm text-slate-400">Ringkasan status pemesanan kendaraan dan aktivitas terbaru.</p>
        </div>
        <div class="flex items-center gap-3">
            <a 
                href="{{ route('bookings.create') }}" 
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Buat Pemesanan
            </a>
        </div>
    </div>

    {{-- Metrics / Stat Cards --}}
    <div class="mb-8 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        
        {{-- Card 1: Total Pemesanan --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Booking</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-white">{{ $totalBookings ?? 0 }}</span>
                <span class="text-xs text-slate-500">transaksi</span>
            </div>
        </div>

        {{-- Card 2: Menunggu Persetujuan --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pending Approval</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-500/10 text-amber-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-amber-400">{{ $pendingBookings ?? 0 }}</span>
                <span class="text-xs text-slate-500">perlu diapprove</span>
            </div>
        </div>

        {{-- Card 3: Disetujui --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Disetujui</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-emerald-400">{{ $approvedBookings ?? 0 }}</span>
                <span class="text-xs text-slate-500">siap jalan</span>
            </div>
        </div>

        {{-- Card 4: Armada Kendaraan --}}
        <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-5 shadow-xl backdrop-blur-xl">
            <div class="flex items-center justify-between">
                <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Kendaraan</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500/10 text-indigo-400">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                </div>
            </div>
            <div class="mt-4 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-white">{{ $totalVehicles ?? 0 }}</span>
                <span class="text-xs text-slate-500">unit aktif</span>
            </div>
        </div>

    </div>

    {{-- Recent Bookings Table --}}
    <div class="rounded-2xl border border-slate-800 bg-slate-900/90 shadow-2xl backdrop-blur-xl">
        <div class="flex items-center justify-between border-b border-slate-800 px-6 py-4">
            <div>
                <h2 class="text-lg font-semibold text-white">Pemesanan Terbaru</h2>
                <p class="text-xs text-slate-400">5 transaksi pemesanan kendaraan paling baru.</p>
            </div>
            <a href="{{ route('bookings.index') }}" class="text-xs font-semibold text-blue-400 hover:text-blue-300">
                Lihat Semua &rarr;
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="border-b border-slate-800 bg-slate-950/60 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th scope="col" class="px-6 py-4">Kode</th>
                        <th scope="col" class="px-6 py-4">Kendaraan</th>
                        <th scope="col" class="px-6 py-4">Driver</th>
                        <th scope="col" class="px-6 py-4">Tanggal Pemakaian</th>
                        <th scope="col" class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($recentBookings ?? [] as $booking)
                        <tr class="transition hover:bg-slate-800/40">
                            <td class="whitespace-nowrap px-6 py-4 font-mono font-semibold text-blue-400">
                                {{ $booking->booking_code }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $booking->vehicle->name }}</div>
                                <div class="text-xs text-slate-500">{{ $booking->vehicle->license_plate }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-slate-200">
                                {{ $booking->driver->name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-xs text-slate-400">
                                {{ $booking->start_date }} s/d {{ $booking->end_date }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-xs font-semibold 
                                    {{ $booking->status == 'approved' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : ($booking->status == 'rejected' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : 'bg-slate-800 text-slate-400 border border-slate-700') }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $booking->status == 'approved' ? 'bg-emerald-400' : ($booking->status == 'rejected' ? 'bg-red-400' : 'bg-slate-400') }}"></span>
                                    {{ strtoupper($booking->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500">
                                Belum ada data pemesanan terbaru.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection