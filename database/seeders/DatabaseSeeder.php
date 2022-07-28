<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(roleSeeder::class);
        User::factory(1)->Coordinator()->create();
        User::factory(1)->TopManager()->create();
        User::factory(20)->Participant()->create();
        Event::factory(10)->create();
    }
}



//- To seed the data into the database use the following command:
//¤ php artisan db::seed 