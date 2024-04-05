<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Word::factory(10)->create();

        \App\Models\User::factory()->create([
            'name' => 'Eleonora',
            'email' => 'eleonora@example.com',
        ]);

        $this->call(LinkSeeder::class);
        $this->call(TagSeeder::class);
    }
}
