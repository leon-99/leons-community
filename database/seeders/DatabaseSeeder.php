<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
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
        User::factory(10)->create();
        User::factory()->create([
            "name" => "Leon",
            "email" => "leonzifer@gmail.com"
        ]);
        User::factory()->create([
            "name" => "Hanifah",
            "email" => "hanifah@gmail.com"
        ]);

        Article::factory()->count(20)->create();
        Comment::factory()->count(80)->create();

        $list = ["HTML", "CSS", "Laravel", "PHP", "JavaScript"];

        foreach($list as $name) {
            Category::create(["name" => $name]);
        }
    }
}
