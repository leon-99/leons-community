<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        User::factory()->create([
            "name" => "Win Khant Aung",
            "email" => "leonzifer@gmail.com"
        ]);
        User::factory()->create([
            "name" => "Hanifah",
            "email" => "hanifah@gmail.com"
        ]);
    }
}
