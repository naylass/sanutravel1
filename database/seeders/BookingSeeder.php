<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('bookings')->insert([
            [
                'user_id' => '2',
                'service_id' => '1',
                'booking_code' => 'BOOK-' . strtoupper(Str::random(8)),
                'phone_number' => '089822116688',
                'pickup_location' => 'Waringin Kurung',
                'destination' => 'Bandara',
                'total_passengers' => '2',
                'price' => '300000',
            ],
            [
                'user_id' => '3',
                'service_id' => '1',
                'booking_code' => 'BOOK-' . strtoupper(Str::random(8)),
                'phone_number' => '089822116689',
                'pickup_location' => 'Merak',
                'destination' => 'Medan',
                'total_passengers' => '1',
                'price' => '300000',
            ],
            [
                'user_id' => '4',
                'service_id' => '2',
                'booking_code' => 'BOOK-' . strtoupper(Str::random(8)),
                'phone_number' => '089822116680',
                'pickup_location' => 'Ciwandan',
                'destination' => 'Palembang',
                'total_passengers' => '2',
                'price' => '600000',
            ],
        ]);
    }
}
