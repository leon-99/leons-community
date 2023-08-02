<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\ArticleSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\UserSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
