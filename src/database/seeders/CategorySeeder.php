<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $root = Category::create([
            'name' => 'All',
            'slug' => 'all',
            'parent_id' => null,
            'order' => 0,
        ]);

        $dresses = Category::create([
            'name' => 'Dresses',
            'slug' => 'dresses',
            'parent_id' => $root->id,
            'order' => 1,
        ]);

        Category::create([
            'name' => 'Long dresses',
            'slug' => 'long_dresses',
            'parent_id' => $dresses->id,
            'order' => 1,
        ]);

        $sweaters = Category::create([
            'name' => 'Sweaters',
            'slug' => 'sweaters',
            'parent_id' => $root->id,
            'order' => 2,
        ]);

        Category::create([
            'name' => 'Hooded sweatshirts',
            'slug' => 'hooded_sweaters',
            'parent_id' => $sweaters->id,
            'order' => 1,
        ]);
    }
}
