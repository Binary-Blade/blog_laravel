<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->createOne([
            'name' => 'Valou Test',
            'email' => 'houvillev@gmail.com',
            'password' => bcrypt('admin2222'),
        ]);

        // Optionally, create more users
        // User::factory()->count(10)->create();
    }
}

