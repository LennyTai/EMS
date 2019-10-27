<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'admin',
                'display_name' => 'Administrator',
                'description' => 'User has access to all system functionality'
            ],
            [
                'name' => 'user',
                'display_name' => 'User',
                'description' => 'User can only create and edit data in the system'
            ]
        ];

        foreach ($roles as $key => $value) {
            Role::create($value);
        }
    }
}