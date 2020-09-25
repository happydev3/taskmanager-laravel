<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'    => 1,
                'title' => 'Admin',
            ],
            [
                'id'    => 2,
                'title' => 'User',
            ],
            [
                'id'    => 3,
                'title' => 'Project Manager',
            ],
            [
                'id'    => 4,
                'title' => 'Field Manager',
            ],
            [
                'id'    => 5,
                'title' => 'Party Chief',
            ],
            [
                'id'    => 6,
                'title' => 'Helper',
            ],
            [
                'id'    => 7,
                'title' => 'Drafting Manager',
            ],
            [
                'id'    => 8,
                'title' => 'Drafter',
            ],
            [
                'id'    => 9,
                'title' => 'Reviewer',
            ],
        ];

        Role::insert($roles);
    }
}
