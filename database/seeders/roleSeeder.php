<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class roleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Roles = [
            [
                'label' => 'Coordinator',
            ],
            [
                'label' => 'TopManager',
            ],
            [
                'label' => 'Participant',
            ],
        ];

        foreach($Roles as $role)
        {
            Role::create($role);
        }
    }
}
