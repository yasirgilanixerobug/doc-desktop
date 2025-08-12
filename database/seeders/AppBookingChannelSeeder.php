<?php

namespace Database\Seeders;

use App\Models\AppBookingChannel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppBookingChannelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('app_booking_channels')->count() == 0)
        {
            dump('Create App Booking Channel');
            AppBookingChannel::insert(
                [
                    [
                        'name'          => 'Website',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'      => 'App',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                ]
            );
        } else { dump('App Booking Channel Table Not Empty Look like Seeder are already run '); }
    }
}
