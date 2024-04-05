<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Word;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $word_ids = Word::pluck('id')->toArray();

        $tags = [
            ['label' => 'HTML', 'color' => '#F16524'],
            ['label' => 'CSS', 'color' => '#2465F1'],
            ['label' => 'JavaScript', 'color' => '#F7E018'],
            ['label' => 'Bootstrap', 'color' => '#7E0AF9'],
            ['label' => 'Vue', 'color' => '#327959'],
            ['label' => 'SQL', 'color' => '#1672C6'],
            ['label' => 'PHP', 'color' => '#7A86B8'],
            ['label' => 'Laravel', 'color' => '#EF3F31'],
        ];

        foreach($tags as $tag) {
            $new_tag = new Tag();

            $new_tag->label = $tag['label'];
            $new_tag->color = $tag['color'];

            $new_tag->save();

            $tag_word = array_filter($words_ids, fn () => rand(0,1));
            $new_tag->tags()->attach($tag_word);
        }
    }
}
