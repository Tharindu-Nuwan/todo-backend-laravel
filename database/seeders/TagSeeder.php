<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = ['Work', 'Study', 'Entertainment', 'Family'];

        foreach($tags as $tag) {
            Tag::create([
                'tag_name' => $tag,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}