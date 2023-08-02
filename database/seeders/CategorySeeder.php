<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = ["HTML", "CSS", "Laravel", "PHP", "JavaScript"];

        foreach($list as $name) {
            Category::create(["name" => $name]);
        }
    }
}
