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
            'https://it.wikipedia.org/wiki/Pagina_principale',
            'https://www.youtube.com',
            'https://www.google.com',
            'https://www.facebook.com',
            'https://www.twitch.tv',
            'https://www.instagram.com',
            'https://boolean.careers/corso/full-stack-web-development',
            'https://www.amazon.it',
            'https://it.linkedin.com'
        ];

        $word_ids = Word::pluck('id')->toArray();
        foreach ($links as $link) {
            $new_link = new Link();
            $new_link->word_id = Arr::random($word_ids);
            $new_link->url = $link;
            $new_link->save();
        }
    }
}
