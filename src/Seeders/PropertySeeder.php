<?php

namespace Milestone\Eleoi\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run():void
    {
        DB::table('_properties')->insert(SeedMasterFn(self::$CONTENTS));
    }

    private static array $CONTENTS = [
        ['master' => 1, 'index' => 'Y', 'name' => 'category'],
        ['master' => 1, 'index' => 'Y', 'name' => 'brand'],
        ['master' => 1, 'index' => 'Y', 'name' => 'division'],
        ['master' => 1, 'index' => 'Y', 'name' => 'department'],
        ['master' => 1, 'index' => 'Y', 'name' => 'group'],
        ['master' => 1, 'index' => 'N', 'name' => 'units'],
        ['master' => 3, 'index' => 'N', 'name' => 'item'],
        ['master' => 3, 'index' => 'N', 'name' => 'unit'],
    ];
}
