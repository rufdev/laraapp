<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $path = './master.sql';
        $path = base_path().'/database/seeders/master.sql';
        DB::unprepared(file_get_contents($path));
        $path = base_path().'/database/seeders/survey.sql';
        DB::unprepared(file_get_contents($path));
        $this->command->info('Master table seeded!');
    }
}
