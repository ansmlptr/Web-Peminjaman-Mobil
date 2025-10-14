<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test customer
        Customer::create([
            'nama' => 'Test Customer',
            'email' => 'customer@test.com',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Test No. 123, Jakarta',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // Create additional random customers
        Customer::factory(10)->create();
    }
}