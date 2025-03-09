<?php

namespace Database\Seeders;

use App\Models\Transaction;
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
         User::factory(100)->create();


        $this->call(ProductSeeder::class);
        // $this->call(StockSeeder::class);
        // $this->call(ExpenseSeeder::class);
        // $this->call(TransactionSeeder::class);
         $this->call(StuffSeeder::class);
        // $this->call(OrderSeeder::class);
         $this->call(CategorySeeder::class);


       
        $this->call([
            AdminUserSeeder::class,
        ]);
    }
}
