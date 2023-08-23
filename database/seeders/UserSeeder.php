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
        User::factory(20)->create();
        User::factory()->create([
            "name" => "Win Khant Aung",
            "email" => "leonzifer@gmail.com",
            "is_admin" => true,
            "profile" => 'profile-pictures/11/1692422436.png'
        ]);
        User::factory()->create([
            "name" => "Hanifah",
            "email" => "hanifah@gmail.com"
        ]);
    }
}
