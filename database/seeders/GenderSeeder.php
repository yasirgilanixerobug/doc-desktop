<?php

namespace Database\Seeders;

use App\Models\Gender;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class GenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('genders')->count() == 0)
        {
            dump('Create genders');
            $user = Gender::insert(
                [
                    [
                        'name'          => 'Male',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'      => 'Female',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'      => 'Other',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                ]
            );
        } else { dump('Gender Table Not Empty Look like Seeder are already run '); }
    }
}
