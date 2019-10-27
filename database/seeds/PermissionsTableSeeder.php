<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'create',
                'display_name' => 'Create Record',
                'description' => 'Allow user to create a new record'
            ],
            [
                'name' => 'edit',
                'display_name' => 'Edit Record',
                'description' => 'Allow user to edit an existing record'
            ],
            [
                'name' => 'delete',
                'display_name' => 'Delete Record',
                'description' => 'Allow user to delete an existing record'
            ],
            [
                'name' => 'users',
                'display_name' => 'Manage Users',
                'description' => 'Allow user to manage system users'
            ],
            [
                'name' => 'salary',
                'display_name' => 'Manage Salary',
                'description' => 'Allow user to manage employees salary'
            ]
        ];

        foreach ($permissions as $key => $value) {
            Permission::create($value);
        }
    }
}
