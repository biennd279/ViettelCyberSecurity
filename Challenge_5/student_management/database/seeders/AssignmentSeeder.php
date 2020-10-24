<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AssignmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('assignments')
            ->insert([
                'name' => 'HTML',
                'user_id' => DB::table('users')->first()->id,
                'description' => 'create simple html page'
            ]);
    }
}
