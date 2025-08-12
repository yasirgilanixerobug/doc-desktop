<?php

namespace Database\Seeders;

use App\Models\AppointmentStatus;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('appointment_statuses')->count() == 0)
        {
            dump('Create Appointment Status');
            AppointmentStatus::insert(
                [
                    [
                        'name'          => 'Pending Approval',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'Complete',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'Cancelled By Provider',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'No Show',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'Confirmed',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'Cancelled By Patient',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                ]
            );
        } else { dump('Appointment Status Table Not Empty Look like Seeder are already run '); }
    }
}
