<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSizeSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //seed the sizes table with 0 is small, 1 is medium, 2 is large
        $sizes = [
            ['name' => 'small'],
            ['name' => 'medium'],
            ['name' => 'large'],
        ];
        DB::table('sizes')->insert($sizes);
    }
}
