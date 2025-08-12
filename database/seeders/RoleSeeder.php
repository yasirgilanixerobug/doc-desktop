<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('roles')->count() == 0)
        {
            dump("Start Adding Roles");
            DB::table('roles')->insert(
                [
                    [
                        'name'          => 'admin',
                        'guard_name'    => 'web',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'owner',
                        'guard_name'    => 'web',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'provider',
                        'guard_name'    => 'web',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'office',
                        'guard_name'    => 'web',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'receptionist',
                        'guard_name'    => 'web',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'other-staff',
                        'guard_name'    => 'web',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'patient',
                        'guard_name'    => 'web',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                ],
            );
        } else { dump('Role Table Not Empty Look like Seeder are already run '); }
    }
}
