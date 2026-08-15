@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    
    {{-- Header Page --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">Daftar Pemesanan Kendaraan</h1>
            <p class="mt-1 text-sm text-slate-400">Kelola dan pantau seluruh status pemesanan kendaraan operasional.</p>
        </div>
        <div class="flex items-center gap-3">
            {{-- Button Export Excel --}}
            <a 
                href="{{ route('bookings.export') }}" 
                class="inline-flex items-center justify-center gap-2 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-2.5 text-sm font-semibold text-emerald-400 transition hover:bg-emerald-500/20 focus:outline-none focus:ring-2 focus:ring-emerald-500/50"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Export Excel
            </a>

            {{-- Button Tambah Pemesanan --}}
            <a 
                href="{{ route('bookings.create') }}" 
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
            >
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Pemesanan
            </a>
        </div>
    </div>

    {{-- Alert Success --}}
    @if(session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-lg border border-emerald-500/20 bg-emerald-500/10 p-4 text-sm text-emerald-400">
            <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- Table Card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/90 shadow-2xl backdrop-blur-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-300">
                <thead class="border-b border-slate-800 bg-slate-950/60 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th scope="col" class="px-6 py-4">Kode</th>
                        <th scope="col" class="px-6 py-4">Kendaraan</th>
                        <th scope="col" class="px-6 py-4">Driver</th>
                        <th scope="col" class="px-6 py-4">Tanggal Pemakaian</th>
                        <th scope="col" class="px-6 py-4">Penyetujui Lvl 1</th>
                        <th scope="col" class="px-6 py-4">Penyetujui Lvl 2</th>
                        <th scope="col" class="px-6 py-4">Status Booking</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($bookings as $booking)
                        @php
                            $lvl1 = $booking->approvals->where('level', 1)->first();
                            $lvl2 = $booking->approvals->where('level', 2)->first();
                        @endphp
                        <tr class="transition hover:bg-slate-800/40">
                            {{-- Kode --}}
                            <td class="whitespace-nowrap px-6 py-4 font-mono font-semibold text-blue-400">
                                {{ $booking->booking_code }}
                            </td>

                            {{-- Kendaraan --}}
                            <td class="px-6 py-4">
                                <div class="font-medium text-white">{{ $booking->vehicle->name }}</div>
                                <div class="text-xs text-slate-500">{{ $booking->vehicle->license_plate }}</div>
                            </td>

                            {{-- Driver --}}
                            <td class="whitespace-nowrap px-6 py-4 text-slate-200">
                                {{ $booking->driver->name }}
                            </td>

                            {{-- Tanggal --}}
                            <td class="whitespace-nowrap px-6 py-4 text-xs text-slate-400">
                                <div>{{ $booking->start_date }}</div>
                                <div class="text-slate-600">s/d {{ $booking->end_date }}</div>
                            </td>

                            {{-- Penyetujui Lvl 1 --}}
                            <td class="px-6 py-4">
                                <div class="text-xs text-slate-300">{{ $lvl1?->approver?->name ?? '-' }}</div>
                                <span class="mt-1 inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium 
                                    {{ $lvl1?->status == 'approved' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : ($lvl1?->status == 'rejected' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20') }}">
                                    {{ ucfirst($lvl1?->status ?? 'pending') }}
                                </span>
                            </td>

                            {{-- Penyetujui Lvl 2 --}}
                            <td class="px-6 py-4">
                                <div class="text-xs text-slate-300">{{ $lvl2?->approver?->name ?? '-' }}</div>
                                <span class="mt-1 inline-flex items-center rounded-full px-2 py-0.5 text-[10px] font-medium 
                                    {{ $lvl2?->status == 'approved' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/20' : ($lvl2?->status == 'rejected' ? 'bg-red-500/10 text-red-400 border border-red-500/20' : 'bg-amber-500/10 text-amber-400 border border-amber-500/20') }}">
                                    {{ ucfirst($lvl2?->status ?? 'pending') }}
                                </span>
                            </td>

                            {{-- Status Booking --}}
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
                            <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                <svg class="mx-auto h-8 w-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p class="mt-2 text-sm font-medium">Belum ada pemesanan kendaraan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
            <div class="border-t border-slate-800 bg-slate-950/40 px-6 py-4 text-slate-400">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection