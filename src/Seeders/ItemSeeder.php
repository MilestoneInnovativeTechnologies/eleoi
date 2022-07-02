<?php

namespace Milestone\Eleoi\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $master = DB::table('_masters')->where('name','ITEM')->value('id');
        $CONTENTS = array_map(fn($line) => array_combine(['id','name'],explode("\t",trim($line))),file(Storage::path('ITEMS.txt')));
        DB::table('_master_data')->where(compact('master'))->delete();
        foreach (array_chunk(SeedMasterFn($CONTENTS,compact('master')),1000) as $chunk) DB::table('_master_data')->insert($chunk);
    }
}
