<?php

use Illuminate\Database\Seeder;

class SeatpreferenceSeeder extends Seeder
{
    public function run()
    {
         $seatName = [
           	'WINDOW',
           	'ASILE',
           	'EMERGENCY EXIT WINDOW',
           	'EMERGENCY EXIT ASILE',
           	'EMERGENCY EXIT ANY',
           	'NO EMERGENCY EXIT ASILE',
           	'NO EMERGENCY EXIT WINDOW',
           	'LAST ROW ASILE',
           	'LAST ROW WINDOW',
           	'NO WINGS WINDOW',
           	'NO WINGS ASILE'
        ];

          foreach ($seatName as $k => $row) {
        	DB::table('seat_preferences')->insert(['name' => $row]);
        }
    }
}
