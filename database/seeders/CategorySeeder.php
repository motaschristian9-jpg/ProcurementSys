<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Concreate Works',
            'Masonry works',
            'roofing',
            'carpentry works',
            'plumbing & sanitary materials',
            'structural steel and metal',
            'doors',
            'windows and glass',
            'architectural/finishes',
            'ceiling works',
            'electrical',
            'hardware/consumables',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($category)],
                ['name' => $category]
            );
        }
    }
}
