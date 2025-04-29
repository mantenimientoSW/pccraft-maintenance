<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Para crear los 2 usuarios: Cliente y Admin
        $this->call(UsersTableSeeder::class);
        //Para crear productos
        $this->call(ProductsSeeder::class);

        // Para crear las direcciones
        $this->call(DireccionesSeeder::class);
        // Para crear las ordenes
        $this->call(OrdersSeeder::class);

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
