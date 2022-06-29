<?php

namespace Milestone\Eleoi\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BarcodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'barcode'; $MASTER_PROPERTIES = [];
        $barcode_master_id = DB::table('_masters')->where('name',Str::upper($name))->first()->id;
        $item_property_id = DB::table('_properties')->where(['name' => 'item','master' => $barcode_master_id])->first()->id;
        $unit_property_id = DB::table('_properties')->where(['name' => 'unit','master' => $barcode_master_id])->first()->id;
        $start = Arr::first(DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'l9' AND TABLE_NAME = '_master_data';"))->AUTO_INCREMENT;
        $MASTER_CONTENTS = array_map(function($line) use(&$start,&$MASTER_PROPERTIES,$item_property_id,$unit_property_id,$barcode_master_id){
            $id = $start++; list($barcode,$item,$unit) = explode("\t",trim($line));
            $MASTER_PROPERTIES[] = ['data' => $id,'property' => $item_property_id,'value' => $item];
            $MASTER_PROPERTIES[] = ['data' => $id,'property' => $unit_property_id,'value' => $unit];
            return ['id' => $id, 'master' => $barcode_master_id, 'name' => $barcode];
        },file(Storage::path(str($name)->plural()->upper()->append('.txt')->toString())));

        DB::table('_master_data')->where('master',$barcode_master_id)->delete();
        foreach (array_chunk(SeedMasterFn($MASTER_CONTENTS),1000) as $chunk) DB::table('_master_data')->insert($chunk);

        DB::table('_master_properties')->whereIn('property',[$item_property_id,$unit_property_id])->delete();
        foreach (array_chunk(SeedMasterFn($MASTER_PROPERTIES),1000) as $chunk) DB::table('_master_properties')->insert($chunk);
    }
}
