<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemUnitsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'item_unit'; $property = DB::table('_properties')->where(['name' => 'units','master' => 1])->first()->id;
        $CONTENTS = array_map(fn($line) => array_combine(['data','value'],explode("\t",trim($line))),file(Storage::path(str($name)->plural()->append('.txt')->toString())));
        DB::table('_master_properties')->where(compact('property'))->delete();
        foreach (array_chunk(SeedMasterFn($CONTENTS,compact('property')),1000) as $chunk) DB::table('_master_properties')->insert($chunk);
    }
}
