<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * Query data pemesanan
    */
    public function collection()
    {
        return Booking::with(['vehicle', 'driver', 'approvals.approver'])->latest()->get();
    }

    /**
    * Header kolom Excel
    */
    public function headings(): array
    {
        return [
            'Kode Booking',
            'Nama Kendaraan',
            'Plat Nomor',
            'Nama Driver',
            'Tgl Mulai',
            'Tgl Selesai',
            'Penyetujui Lvl 1',
            'Status Lvl 1',
            'Penyetujui Lvl 2',
            'Status Lvl 2',
            'Status Booking',
            'Keperluan',
        ];
    }

    /**
    * Mapping baris data Excel
    */
    public function map($booking): array
    {
        $lvl1 = $booking->approvals->where('level', 1)->first();
        $lvl2 = $booking->approvals->where('level', 2)->first();

        return [
            $booking->booking_code,
            $booking->vehicle->name ?? '-',
            $booking->vehicle->license_plate ?? '-',
            $booking->driver->name ?? '-',
            $booking->start_date,
            $booking->end_date,
            $lvl1?->approver?->name ?? '-',
            ucfirst($lvl1?->status ?? 'pending'),
            $lvl2?->approver?->name ?? '-',
            ucfirst($lvl2?->status ?? 'pending'),
            ucwords(strtolower($booking->status)),
            $booking->purpose,
        ];
    }
}