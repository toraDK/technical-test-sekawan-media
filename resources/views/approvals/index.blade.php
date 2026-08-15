@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-6 py-8 lg:px-8">
    
    <!-- Page Header -->
    <div class="mb-8 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">Persetujuan Pemesanan</h1>
            <p class="mt-1 text-sm text-slate-400">Kelola pengajuan pemesanan kendaraan yang membutuhkan tindakan atau tinjauan Anda.</p>
        </div>
    </div>

    <!-- Alert Success / Error -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 flex items-center justify-between rounded-xl border border-emerald-500/30 bg-emerald-500/10 p-4 text-emerald-400 backdrop-blur-md" role="alert">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium">{{ session('success') }}</span>
            </div>
            <button @click="show = false" type="button" class="text-emerald-400/70 hover:text-emerald-300">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition class="mb-6 flex items-center justify-between rounded-xl border border-rose-500/30 bg-rose-500/10 p-4 text-rose-400 backdrop-blur-md" role="alert">
            <div class="flex items-center gap-3">
                <svg class="h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span class="text-sm font-medium">{{ session('error') }}</span>
            </div>
            <button @click="show = false" type="button" class="text-rose-400/70 hover:text-rose-300">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    @endif

    <!-- Data Table Container -->
    <div class="overflow-hidden rounded-2xl border border-slate-800 bg-slate-900/60 shadow-xl backdrop-blur-xl">
        <div class="w-full overflow-x-auto overscroll-x-contain">
            <table class="min-w-max w-full text-left text-sm text-slate-300">
                <thead class="border-b border-slate-800 bg-slate-900/80 text-xs uppercase tracking-wider text-slate-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">Kode</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Pemohon</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Kendaraan</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Driver</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Tanggal Pemakaian</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Level</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/60">
                    @forelse($approvals as $item)
                        <tr x-data="{ openModal: false }" class="transition hover:bg-slate-800/30">
                            <!-- Kode Booking -->
                            <td class="whitespace-nowrap px-6 py-4 font-semibold text-white">
                                {{ $item->booking->booking_code ?? '-' }}
                            </td>

                            <!-- Pemohon -->
                            <td class="whitespace-nowrap px-6 py-4 text-slate-200">
                                {{ $item->booking->admin->name ?? '-' }}
                            </td>

                            <!-- Kendaraan -->
                            <td class="px-6 py-4">
                                <div class="font-medium text-slate-200">{{ $item->booking->vehicle->name ?? '-' }}</div>
                                <div class="text-xs text-slate-400">{{ $item->booking->vehicle->license_plate ?? '' }}</div>
                            </td>

                            <!-- Driver -->
                            <td class="whitespace-nowrap px-6 py-4 text-slate-300">
                                {{ $item->booking->driver->name ?? 'Tanpa Driver' }}
                            </td>

                            <!-- Tanggal Pemakaian -->
                            <td class="whitespace-nowrap px-6 py-4 text-xs text-slate-300">
                                {{ \Carbon\Carbon::parse($item->booking->start_date)->format('d M Y') }} 
                                <span class="text-slate-500">s/d</span> 
                                {{ \Carbon\Carbon::parse($item->booking->end_date)->format('d M Y') }}
                            </td>

                            <!-- Level -->
                            <td class="whitespace-nowrap px-6 py-4">
                                <span class="inline-flex items-center rounded-md bg-blue-500/10 px-2.5 py-1 text-xs font-medium text-blue-400 ring-1 ring-inset ring-blue-500/20">
                                    Level {{ $item->level }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="whitespace-nowrap px-6 py-4">
                                @if($item->status == 'approved')
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500/20 bg-emerald-500/10 px-3 py-1 text-xs font-semibold text-emerald-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                                        Approved
                                    </span>
                                @elseif($item->status == 'rejected')
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-rose-500/20 bg-rose-500/10 px-3 py-1 text-xs font-semibold text-rose-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-400"></span>
                                        Rejected
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 rounded-full border border-amber-500/20 bg-amber-500/10 px-3 py-1 text-xs font-semibold text-amber-400">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                        Pending
                                    </span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="whitespace-nowrap px-6 py-4 text-right">
                                @if($item->status == 'pending')
                                    <button @click="openModal = true" type="button" class="inline-flex items-center gap-1.5 rounded-lg bg-blue-600 px-3 py-1.5 text-xs font-semibold text-white shadow-sm transition hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                        Proses
                                    </button>

                                    <!-- Alpine Modal Approval -->
                                    <template x-teleport="body">
                                        <div x-show="openModal" 
                                             x-transition:enter="ease-out duration-200"
                                             x-transition:enter-start="opacity-0"
                                             x-transition:enter-end="opacity-100"
                                             x-transition:leave="ease-in duration-150"
                                             x-transition:leave-start="opacity-100"
                                             x-transition:leave-end="opacity-0"
                                             @keydown.escape.window="openModal = false"
                                             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-sm"
                                             x-cloak>
                                            
                                            <!-- Modal Card -->
                                            <div @click.away="openModal = false" 
                                                 class="w-full max-w-lg overflow-hidden rounded-2xl border border-slate-800 bg-slate-900 p-6 text-left shadow-2xl transition-all">
                                                
                                                <form action="{{ route('approvals.process', $item->id) }}" method="POST">
                                                    @csrf
                                                    
                                                    <!-- Modal Header -->
                                                    <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                                                        <h3 class="text-base font-semibold text-white">
                                                            Persetujuan Booking [<span class="text-blue-400">{{ $item->booking->booking_code }}</span>]
                                                        </h3>
                                                        <button @click="openModal = false" type="button" class="rounded-lg p-1 text-slate-400 hover:bg-slate-800 hover:text-white">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <!-- Modal Body -->
                                                    <div class="my-5 space-y-4">
                                                        <div class="rounded-xl border border-slate-800 bg-slate-950/50 p-3.5">
                                                            <span class="text-xs font-medium text-slate-400">Tujuan Pemakaian:</span>
                                                            <p class="mt-1 text-sm text-slate-200">{{ $item->booking->purpose }}</p>
                                                        </div>

                                                        <div>
                                                            <label class="block text-xs font-medium text-slate-300 mb-1.5">Catatan / Alasan (Opsional)</label>
                                                            <textarea name="note" rows="3" class="w-full rounded-xl border border-slate-800 bg-slate-950 p-3 text-sm text-white placeholder-slate-500 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500" placeholder="Masukkan catatan..."></textarea>
                                                        </div>
                                                    </div>

                                                    <!-- Modal Footer -->
                                                    <div class="flex items-center justify-end gap-3 border-t border-slate-800 pt-4">
                                                        <button type="submit" name="action" value="rejected" class="rounded-lg border border-rose-500/20 bg-rose-500/10 px-4 py-2 text-xs font-semibold text-rose-400 hover:bg-rose-500/20 transition">
                                                            Tolak
                                                        </button>
                                                        <button type="submit" name="action" value="approved" class="rounded-lg bg-blue-600 px-4 py-2 text-xs font-semibold text-white hover:bg-blue-500 transition">
                                                            Setujui
                                                        </button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </template>
                                @else
                                    <span class="text-xs font-medium text-slate-500">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                <svg class="mx-auto h-8 w-8 text-slate-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Belum ada pengajuan yang membutuhkan persetujuan Anda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($approvals->hasPages())
            <div class="border-t border-slate-800 px-6 py-4">
                {{ $approvals->links() }}
            </div>
        @endif
    </div>
</div>
@endsection