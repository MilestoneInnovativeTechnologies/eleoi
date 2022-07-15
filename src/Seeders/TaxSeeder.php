<?php

namespace Milestone\Eleoi\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $master = DB::table('_masters')->where('name','TAX')->value('id');
        $percentage_property_id = DB::table('_properties')->where(['name' => 'percentage','master' => $master])->value('id');
        $start = Arr::first(DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "' AND TABLE_NAME = '_master_data';"))->AUTO_INCREMENT;
        $MASTER_PROPERTIES = [];
        $CONTENTS = array_map(function($line) use(&$start,&$MASTER_PROPERTIES,$percentage_property_id){
            list($name,$percentage) = explode("\t",trim($line));
            $MASTER_PROPERTIES[] = ['data' => $start,'property' => $percentage_property_id,'value' => $percentage];
            return ['id' => $start++,'name' => $name];
        },file(Storage::path('TAXES.txt')));
        DB::table('_master_data')->where(compact('master'))->delete();
        foreach (array_chunk(SeedMasterFn($CONTENTS,compact('master')),1000) as $chunk) DB::table('_master_data')->insert($chunk);
        DB::table('_master_properties')->where('property',$percentage_property_id)->delete();
        foreach (array_chunk(SeedMasterFn($MASTER_PROPERTIES),1000) as $chunk) DB::table('_master_properties')->insert($chunk);
    }
}
