<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'department';
        $CONTENTS = array_map(fn($line) => array_combine(['value','ids'],explode("\t",trim($line))),file(Storage::path(str($name)->plural()->append('.txt')->toString())));
        $property = DB::table('_properties')->where(compact('name'))->first()->id;
        DB::table('_property_masters')->where(compact('property'))->delete();
        foreach (array_chunk(SeedMasterFn($CONTENTS,compact('property'),'value'),1000) as $chunk) DB::table('_property_masters')->insert($chunk);
    }
}
