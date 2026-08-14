<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Regions
        DB::table('regions')->insert([
            ['name' => 'Kantor Pusat (Jakarta)', 'type' => 'head_office', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kantor Cabang (Makassar)', 'type' => 'branch_office', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tambang Nikel Site A (Morowali)', 'type' => 'mining_site', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tambang Nikel Site B (Sorowako)', 'type' => 'mining_site', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tambang Nikel Site C (Konawe)', 'type' => 'mining_site', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tambang Nikel Site D (Halmahera)', 'type' => 'mining_site', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tambang Nikel Site E (Kolaka)', 'type' => 'mining_site', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tambang Nikel Site F (Pomalaa)', 'type' => 'mining_site', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // 2. Seed Users
        DB::table('users')->insert([
            [
                'name' => 'Admin Pool Fleet',
                'email' => 'admin@nikel.co.id',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'position' => 'Staff Pengelola Kendaraan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'atasan1@nikel.co.id',
                'password' => Hash::make('password123'),
                'role' => 'approver',
                'position' => 'Supervisor Tambang (Level 1)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'atasan2@nikel.co.id',
                'password' => Hash::make('password123'),
                'role' => 'approver',
                'position' => 'Head of Fleet & Logistics (Level 2)',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 3. Seed Vehicles
        DB::table('vehicles')->insert([
            [
                'region_id' => 3,
                'name' => 'Toyota Hilux Single Cab 4x4',
                'license_plate' => 'B 9011 NKL',
                'type' => 'cargo',
                'ownership' => 'company',
                'rental_company' => null,
                'fuel_consumption' => 10.50,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'region_id' => 3,
                'name' => 'Toyota Fortuner 4x4',
                'license_plate' => 'B 9012 NKL',
                'type' => 'personnel',
                'ownership' => 'company',
                'rental_company' => null,
                'fuel_consumption' => 8.20,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'region_id' => 4,
                'name' => 'Mitsubishi Triton 4x4',
                'license_plate' => 'B 9013 NKL',
                'type' => 'cargo',
                'ownership' => 'rented',
                'rental_company' => 'PT Rent Car Nusantara',
                'fuel_consumption' => 9.80,
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 4. Seed Drivers
        DB::table('drivers')->insert([
            [
                'name' => 'Joko Widodo',
                'phone' => '081234567890',
                'license_number' => 'SIM-B1-998877',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rudi Hermawan',
                'phone' => '081298765432',
                'license_number' => 'SIM-A-112233',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}