<?php

namespace Milestone\Eleoi\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    use WithoutModelEvents;
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        ini_set("memory_limit","1024M");
        $this->call([
            MasterSeeder::class,
            PropertySeeder::class,
            ItemSeeder::class,
            UnitSeeder::class,
            CategorySeeder::class,
            BrandSeeder::class,
            DepartmentSeeder::class,
            DivisionSeeder::class,
            GroupSeeder::class,
            ItemUnitsSeeder::class,
            TaxSeeder::class,
            BarcodeSeeder::class,
            PriceListSeeder::class,
            PricesSeeder::class,
        ]);
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
