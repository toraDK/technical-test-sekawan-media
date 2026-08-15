@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-10 sm:px-6 lg:px-8">

    {{-- Header Page --}}
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-white sm:text-3xl">Form Pemesanan Kendaraan</h1>
            <p class="mt-1 text-sm text-slate-400">Lengkapi formulir di bawah ini untuk mengajukan peminjaman kendaraan operasional.</p>
        </div>
        <a 
            href="{{ route('bookings.index') }}" 
            class="inline-flex items-center gap-2 rounded-lg border border-slate-700 bg-slate-800 px-4 py-2.5 text-sm font-semibold text-slate-300 transition hover:bg-slate-700 hover:text-white"
        >
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Alert Error --}}
    @if(session('error'))
        <div class="mb-6 flex items-center gap-3 rounded-lg border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-400">
            <svg class="h-5 w-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    {{-- Form Card --}}
    <div class="rounded-2xl border border-slate-800 bg-slate-900/90 p-6 shadow-2xl backdrop-blur-xl sm:p-8">
        <form action="{{ route('bookings.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                {{-- Kendaraan --}}
                <div class="md:col-span-1">
                    <label for="vehicle_id" class="block text-sm font-medium text-slate-300">Pilih Kendaraan <span class="text-red-400">*</span></label>
                    <select 
                        name="vehicle_id" 
                        id="vehicle_id" 
                        class="mt-2 block w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2.5 text-sm text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('vehicle_id') border-red-500 @enderror" 
                        required
                    >
                        <option value="" class="text-slate-500">-- Pilih Kendaraan --</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                {{ $vehicle->name }} ({{ $vehicle->license_plate }}) - {{ ucfirst($vehicle->ownership) }}
                            </option>
                        @endforeach
                    </select>
                    @error('vehicle_id')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Driver --}}
                <div class="md:col-span-1">
                    <label for="driver_id" class="block text-sm font-medium text-slate-300">Pilih Driver <span class="text-red-400">*</span></label>
                    <select 
                        name="driver_id" 
                        id="driver_id" 
                        class="mt-2 block w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2.5 text-sm text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('driver_id') border-red-500 @enderror" 
                        required
                    >
                        <option value="" class="text-slate-500">-- Pilih Driver --</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                {{ $driver->name }} (Telp: {{ $driver->phone }})
                            </option>
                        @endforeach
                    </select>
                    @error('driver_id')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Mulai --}}
                <div class="md:col-span-1">
                    <label for="start_date" class="block text-sm font-medium text-slate-300">Tanggal Mulai <span class="text-red-400">*</span></label>
                    <input 
                        type="date" 
                        name="start_date" 
                        id="start_date" 
                        class="mt-2 block w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2.5 text-sm text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('start_date') border-red-500 @enderror" 
                        value="{{ old('start_date') }}" 
                        required
                    >
                    @error('start_date')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Selesai --}}
                <div class="md:col-span-1">
                    <label for="end_date" class="block text-sm font-medium text-slate-300">Tanggal Selesai <span class="text-red-400">*</span></label>
                    <input 
                        type="date" 
                        name="end_date" 
                        id="end_date" 
                        class="mt-2 block w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2.5 text-sm text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('end_date') border-red-500 @enderror" 
                        value="{{ old('end_date') }}" 
                        required
                    >
                    @error('end_date')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Approver Level 1 --}}
                <div class="md:col-span-1">
                    <label for="approver_1" class="block text-sm font-medium text-slate-300">Penyetujui Level 1 (Atasan Direct) <span class="text-red-400">*</span></label>
                    <select 
                        name="approver_1" 
                        id="approver_1" 
                        class="mt-2 block w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2.5 text-sm text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('approver_1') border-red-500 @enderror" 
                        required
                    >
                        <option value="" class="text-slate-500">-- Pilih Penyetujui Level 1 --</option>
                        @foreach($approvers as $approver)
                            <option value="{{ $approver->id }}" {{ old('approver_1') == $approver->id ? 'selected' : '' }}>
                                {{ $approver->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('approver_1')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Approver Level 2 --}}
                <div class="md:col-span-1">
                    <label for="approver_2" class="block text-sm font-medium text-slate-300">Penyetujui Level 2 (Manajer/Ops) <span class="text-red-400">*</span></label>
                    <select 
                        name="approver_2" 
                        id="approver_2" 
                        class="mt-2 block w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2.5 text-sm text-slate-200 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('approver_2') border-red-500 @enderror" 
                        required
                    >
                        <option value="" class="text-slate-500">-- Pilih Penyetujui Level 2 --</option>
                        @foreach($approvers as $approver)
                            <option value="{{ $approver->id }}" {{ old('approver_2') == $approver->id ? 'selected' : '' }}>
                                {{ $approver->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('approver_2')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keperluan --}}
                <div class="md:col-span-2">
                    <label for="purpose" class="block text-sm font-medium text-slate-300">Keperluan / Tujuan Pemakaian <span class="text-red-400">*</span></label>
                    <textarea 
                        name="purpose" 
                        id="purpose" 
                        rows="3" 
                        class="mt-2 block w-full rounded-lg border border-slate-700 bg-slate-950 px-3.5 py-2.5 text-sm text-slate-200 placeholder-slate-600 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500 @error('purpose') border-red-500 @enderror" 
                        placeholder="Contoh: Kunjungan lapangan ke Cabang Surabaya" 
                        required
                    >{{ old('purpose') }}</textarea>
                    @error('purpose')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex items-center justify-end gap-3 border-t border-slate-800 pt-6">
                <a 
                    href="{{ route('bookings.index') }}" 
                    class="rounded-lg border border-slate-700 px-4 py-2.5 text-sm font-semibold text-slate-300 transition hover:bg-slate-800 hover:text-white"
                >
                    Batal
                </a>
                <button 
                    type="submit" 
                    class="inline-flex items-center gap-2 rounded-lg bg-blue-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Ajukan Pemesanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection