<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('banners')->insert([
            [
                'title' => 'Banner 1',
                'image_url' => 'https://via.placeholder.com/800x400.png?text=Banner+1',
                'link_url' => 'https://example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Banner 2',
                'image_url' => 'https://via.placeholder.com/800x400.png?text=Banner+2',
                'link_url' => 'https://example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Banner 3',
                'image_url' => 'https://via.placeholder.com/800x400.png?text=Banner+3',
                'link_url' => 'https://example.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
