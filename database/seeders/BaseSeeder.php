<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $bases = [
            ['name' => 'Đế mỏng giòn'],
            ['name' => 'Đế dày xốp'],
            ['name' => 'Đế vừa'],
        ];
        DB::table('bases')->insert($bases);
    }
}
