<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();
        Article::factory()->count(20)->create();
        Comment::factory()->count(20)->create();

        $list = ["HTML", "CSS", "Laravel", "PHP", "JavaScript"];

        foreach($list as $name) {
            Category::create(["name" => $name]);
        }
    }
}
