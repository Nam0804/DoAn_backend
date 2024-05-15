<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\Admin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'type' => 0,
            'password' => bcrypt('12345678'),
            'phone' => '1234567890',
        ]);
    }
}
