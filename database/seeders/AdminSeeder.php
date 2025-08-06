<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('users')->count() == 0)
        {
            dump('Create admin and assign role');
            $user = User::create([
                'name'      => 'Admin',
                'email'     => 'admin@doc.com',
                'password'  => Hash::make('12345678'),
                'status_id' => 1,
                'created_at'=> now(),
                'updated_at'=> now(),
            ]);

            $user->assignRole('admin');

        } else { dump('Users Table Not Empty Look like Seeder are already run '); }
    }
}
