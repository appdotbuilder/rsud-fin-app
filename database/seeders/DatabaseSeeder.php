<?php

namespace Database\Seeders;

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

        User::factory()->create([
            'name' => 'Administrator RSUD',
            'email' => 'admin@rsud.go.id',
            'password' => bcrypt('password'),
        ]);

        // Seed financial data
        $this->call(FinancialDataSeeder::class);
    }
}
