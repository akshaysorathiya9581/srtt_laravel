<?php

use Illuminate\Database\Seeder;
use App\AirlineGroup;

class AirlinegroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\AirlineGroup::class, 200000)->create();
    }
}
