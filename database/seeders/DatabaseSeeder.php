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

        AccountCategory::insert([
            ['name' => 'Salary', 'type' => 'credit'],
            ['name' => 'Other Income', 'type' => 'credit'],
            ['name' => 'Family Expense', 'type' => 'debit'],
            ['name' => 'Transport Expense', 'type' => 'debit'],
            ['name' => 'Meal Expense', 'type' => 'debit'],
        ]);
    }
}
