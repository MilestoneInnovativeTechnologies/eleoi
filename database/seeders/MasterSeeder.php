<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('_masters')->truncate();
        DB::table('_masters')->insert(SeedMasterFn(self::$CONTENTS));
    }

    private static array $CONTENTS = ['ITEM','UNIT','BARCODE','DEPARTMENT','DIVISION','CATEGORY','GROUP','BRAND','CUSTOMER','PRICE_LIST'];
}
