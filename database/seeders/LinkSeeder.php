<?php

namespace Database\Seeders;

use App\Models\Link;
use App\Models\Word;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $links = [
            ['name' => 'Wikipedia', 'url' => 'https://it.wikipedia.org/wiki/Pagina_principale'],
            ['name' => 'YouTube', 'url' => 'https://www.youtube.com'],
            ['name' => 'Facebook', 'url' => 'https://www.facebook.com'],
            ['name' => 'Google', 'url' => 'https://www.google.com'],
            ['name' => 'Twitch', 'url' => 'https://www.twitch.tv'],
            ['name' => 'Instagram', 'url' => 'https://www.instagram.com'],
            ['name' => 'Boolean', 'url' => 'https://boolean.careers/corso/full-stack-web-development'],
            ['name' => 'Amazon', 'url' => 'https://www.amazon.it'],
            ['name' => 'Linkedin', 'url' => 'https://it.linkedin.com']
        ];

        $word_ids = Word::pluck('id')->toArray();
        foreach ($links as $link) {
            $new_link = new Link();
            $new_link->word_id = Arr::random($word_ids);
            $new_link->name = $link['name'];
            $new_link->url = $link['url'];
            $new_link->save();
        }
    }
}
