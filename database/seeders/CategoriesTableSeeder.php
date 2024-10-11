<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Futsal', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Basket', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tennis', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Badminton', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mini Soccer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Softball', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
