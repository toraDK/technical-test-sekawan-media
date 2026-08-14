@extends('layouts.app') {{-- Sesuaikan dengan layout utama Anda --}}

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Form Pemesanan Kendaraan</h5>
                </div>
                <div class="card-body">

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('bookings.store') }}" method="POST">
                        @csrf

                        <!-- Kendaraan -->
                        <div class="mb-3">
                            <label for="vehicle_id" class="form-label">Pilih Kendaraan</label>
                            <select name="vehicle_id" id="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kendaraan --</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->name }} ({{ $vehicle->license_plate }}) - {{ ucfirst($vehicle->ownership) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('vehicle_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Driver -->
                        <div class="mb-3">
                            <label for="driver_id" class="form-label">Pilih Driver</label>
                            <select name="driver_id" id="driver_id" class="form-select @error('driver_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Driver --</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}" {{ old('driver_id') == $driver->id ? 'selected' : '' }}>
                                        {{ $driver->name }} (Telp: {{ $driver->phone }})
                                    </option>
                                @endforeach
                            </select>
                            @error('driver_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Tanggal Pemakaian -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" class="form-content form-control @error('start_date') is-invalid @enderror" value="{{ old('start_date') }}" required>
                                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" class="form-control @error('end_date') is-invalid @enderror" value="{{ old('end_date') }}" required>
                                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Approver Level 1 -->
                        <div class="mb-3">
                            <label for="approver_1" class="form-label">Penyetujui Level 1 (Atasan Direct)</label>
                            <select name="approver_1" id="approver_1" class="form-select @error('approver_1') is-invalid @enderror" required>
                                <option value="">-- Pilih Penyetujui Level 1 --</option>
                                @foreach($approvers as $approver)
                                    <option value="{{ $approver->id }}" {{ old('approver_1') == $approver->id ? 'selected' : '' }}>
                                        {{ $approver->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('approver_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Approver Level 2 -->
                        <div class="mb-3">
                            <label for="approver_2" class="form-label">Penyetujui Level 2 (Manajer/Pengelola Ops)</label>
                            <select name="approver_2" id="approver_2" class="form-select @error('approver_2') is-invalid @enderror" required>
                                <option value="">-- Pilih Penyetujui Level 2 --</option>
                                @foreach($approvers as $approver)
                                    <option value="{{ $approver->id }}" {{ old('approver_2') == $approver->id ? 'selected' : '' }}>
                                        {{ $approver->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('approver_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <!-- Keperluan -->
                        <div class="mb-3">
                            <label for="purpose" class="form-label">Keperluan / Tujuan Pemakaian</label>
                            <textarea name="purpose" id="purpose" rows="3" class="form-control @error('purpose') is-invalid @enderror" placeholder="Contoh: Kunjungan lapangan ke Cabang Surabaya" required>{{ old('purpose') }}</textarea>
                            @error('purpose') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success">Ajukan Pemesanan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection