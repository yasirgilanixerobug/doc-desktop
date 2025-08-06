<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(DB::table('statuses')->count() == 0)
        {
            dump('Create Status');
            Status::insert(
                [
                    [
                        'name'          => 'Active',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'Block',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                    [
                        'name'          => 'Temporary Block',
                        'created_at'    => now(),
                        'updated_at'    => now(),
                    ],
                ]
            );
        } else { dump('Statuses Table Not Empty Look like Seeder are already run '); }
    }
}
