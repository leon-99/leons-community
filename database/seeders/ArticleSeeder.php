<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;


class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Article::factory()->count(20)->create();
        Article::factory()->count(5)->create([
            'user_id' => 21
        ]);
    }
}
