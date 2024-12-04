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
            ['id' => 1, 'name' => 'Salary', 'type' => 'credit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Other Income', 'type' => 'credit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Family Expense', 'type' => 'debit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Transport Expense', 'type' => 'debit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Meal Expense', 'type' => 'debit', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
