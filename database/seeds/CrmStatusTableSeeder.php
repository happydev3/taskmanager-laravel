<?php

use App\CrmStatus;
use Illuminate\Database\Seeder;

class CrmStatusTableSeeder extends Seeder
{
    public function run()
    {
        $crmStatuses = [
            [
                'id'         => '1',
                'name'       => 'Lead',
                'created_at' => '2020-06-09 10:10:50',
                'updated_at' => '2020-06-09 10:10:50',
            ],
            [
                'id'         => '2',
                'name'       => 'Customer',
                'created_at' => '2020-06-09 10:10:50',
                'updated_at' => '2020-06-09 10:10:50',
            ],
            [
                'id'         => '3',
                'name'       => 'Partner',
                'created_at' => '2020-06-09 10:10:50',
                'updated_at' => '2020-06-09 10:10:50',
            ],
        ];

        CrmStatus::insert($crmStatuses);
    }
}
