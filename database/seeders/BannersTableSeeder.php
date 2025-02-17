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
                'image_url' => 'banner/banner1.jpg',
                'link_url' => 'https://laponid.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Banner 2',
                'image_url' => 'banner/banner2.jpg',
                'link_url' => 'https://laponid.com',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
