<?php

use App\TaskStatus;
use Illuminate\Database\Seeder;

class TaskStatusTableSeeder extends Seeder
{
    public function run()
    {
        $taskStatuses = [
            [
                'id'   => '1',
                'name' => 'Created',
            ],
            [
                'id'   => '2',
                'name' => 'In Field',
            ],
            [
                'id'   => '3',
                'name' => 'In Drafting',
            ],
            [
                'id'   => '4',
                'name' => 'In Review',
            ],
            [
                'id'   => '5',
                'name' => 'Final Stage',
            ],
            [
                'id'   => '6',
                'name' => 'Sent to Authority',
            ],
        ];

        TaskStatus::insert($taskStatuses);
    }
}
