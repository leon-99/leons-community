<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Comment::factory()->count(80)->create();
        Comment::factory()->count(10)->create([
            'user_id' => 12,
            'article_id' => 21
        ]);
    }
}
