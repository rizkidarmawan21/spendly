<?php

namespace Database\Seeders;

use App\Models\AccountCategory;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('rahasia123'),
        ]);

        $data = [
            ['name' => 'Salary', 'type' => 'credit'],
            ['name' => 'Other Income', 'type' => 'credit'],
            ['name' => 'Family Expense', 'type' => 'debit'],
            ['name' => 'Transport Expense', 'type' => 'debit'],
            ['name' => 'Meal Expense', 'type' => 'debit'],
        ];
        foreach ($data as $category) {
            AccountCategory::create($category);
        }
    }
}
