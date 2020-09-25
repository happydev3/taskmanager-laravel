<?php

use App\TaskCity;
use Illuminate\Database\Seeder;

class TaskCitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            [
                'id' => 1,
                'city_name' => 'EDMONTON',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'city_name' => 'FT. SASKATCHEWAN',
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'city_name' => 'ST. ALBERT',
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'city_name' => 'SPRUCEGROVE',
                'created_at' => now(),
            ],
            [
                'id' => 5,
                'city_name' => 'CALMAR',
                'created_at' => now(),
            ],
            [
                'id' => 6,
                'city_name' => 'STRATHCONA COUNTY',
                'created_at' => now(),
            ],
            [
                'id' => 7,
                'city_name' => 'SHERWOOD PARK',
                'created_at' => now(),
            ],
            [
                'id' => 8,
                'city_name' => 'LEDUC',
                'created_at' => now(),
            ],
            [
                'id' => 9,
                'city_name' => 'MORINVILLE',
                'created_at' => now(),
            ],
            [
                'id' => 10,
                'city_name' => 'BEAUMONT',
                'created_at' => now(),
            ],
            [
                'id' => 11,
                'city_name' => 'LEDUC COUNTY',
                'created_at' => now(),
            ],
            [
                'id' => 12,
                'city_name' => 'PARKLAND COUNTY',
                'created_at' => now(),
            ],
        ];

        TaskCity::insert($cities);
    }
}
