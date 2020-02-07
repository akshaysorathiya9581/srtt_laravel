<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MealpreferenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mealName = [
           	'VEGETARIAN HINDU MEAL',
           	'BABY MEAL',
           	'BLAND MEAL',
           	'CHILD MEAL',
           	'CHICKEN MEAL (LY SPECIFIC)',
           	'DIABETIC MEAL',
           	'FRUIT PLATTER',
           	'FISH MEAL',
           	'GLUTEN INTOLERANT MEAL',
           	'HINDU (NON VEGETARIAN) MEAL',
           	'INDIAN VEGETARIAN MEAL',
           	'JAPANESE MEAL',
           	'KOSHER MEAL',
           	'LOW CALORIE MEAL',
           	'LOW FAT MEAL',
           	'LOW SALT MEAL',
           	'MOSLEM MEAL',
           	'NO FISH MEAL (LH SPECIFIC)',
           	'LOW LACTOSE MEAL',
           	'JAPANESE OBENTO MEAL (UA SPECIFIC)',
           	'VEGETARIAN RAW MEAL',
           	'SEA FOOD MEAL',
           	'SPECIAL MEAL, SPECIFY FOOD',
           	'VEGETARIAN VEGAN MEAL',
           	'VEGETARIAN JAIN MEAL MEAL',
           	'VEGETARIAN LACTO-OVO MEAL',
           	'VEGETARIAN ORIENTAL MEAL',
        ];
        $shortMealName = [
           	'AVML',
           	'BBML',
           	'BLML',
           	'CHML',
           	'CNML',
           	'DBML',
           	'FPML',
           	'FSML',
           	'GFML',
           	'HNML',
           	'IVML',
           	'JPML',
           	'KSML',
           	'LCML',
           	'LFML',
           	'LSML',
           	'MOML',
           	'NFML',
           	'NLML',
           	'OBML',
           	'RVML',
           	'SFML',
           	'SPML',
           	'VGML',
           	'VJML',
           	'VLML',
           	'VOML',
        ];


        foreach ($mealName as $k => $meal) {
        	DB::table('meal_preferences')->insert(['short_name' => $shortMealName[$k], 'name' => $meal]);
        }
    }
}
