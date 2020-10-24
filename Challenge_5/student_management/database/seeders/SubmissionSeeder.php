<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('submissions')
            ->insert([
                'assignment_id' => DB::table('assignments')->first()->id,
                'user_id' => DB::table('users')->first()->id,
                'note' => 'some thing'
            ]);
    }
}
