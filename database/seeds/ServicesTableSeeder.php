<?php

use Illuminate\Database\Seeder;
use App\Service;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = [
           	'Cruise',
           	'Domestic Air ticket',
           	'Forex',
           	'Hotel',
           	'Insurance',
           	'International Air Ticket',
           	'Membership Programs',
           	'Package',
           	'Rent a Cab',
           	'Visa',
           	'Internation Sim Card'
        ];


        foreach ($services as $service) {
             Service::create(['name' => $service]);
        }
    }
}
