<?php

namespace Milestone\Eleoi\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'brand';
        $masters = DB::table('_masters')->pluck('id','name');
        $property = DB::table('_properties')->where(['master' => $masters['ITEM'],'name' => $name])->value('id');
        $start = Arr::first(DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '".env('DB_DATABASE')."' AND TABLE_NAME = '_master_data';"))->AUTO_INCREMENT;
        $property_contents = [];
        $master_contents = array_map(function($line) use($property,$masters,&$start,&$master_contents,&$property_contents){
            list($name,$ids) = explode("\t",trim($line));
            $property_contents[] = ['property' => $property,'data' => $start,'ids' => $ids];
            return ['id' => $start++, 'name' => $name];
        },file(Storage::path(str($name)->plural()->append('.txt')->toString())));
        DB::table('_master_data')->where(['master' => $masters[strtoupper($name)]])->delete();
        foreach (array_chunk(SeedMasterFn($master_contents,['master' => $masters[strtoupper($name)]]),1000) as $chunk) DB::table('_master_data')->insert($chunk);
        DB::table('_property_masters')->where(compact('property'))->delete();
        foreach (array_chunk(SeedMasterFn($property_contents),1000) as $chunk) DB::table('_property_masters')->insert($chunk);
    }
}
