<?php

namespace Milestone\Eleoi\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PriceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $masters = DB::table('_masters')->pluck('id','name')->toArray();
        $default_property_id = DB::table('_properties')->where(['name' => 'default','master' => $masters['PRICE_LIST']])->value('id');
        $start = Arr::first(DB::select("SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '" . env('DB_DATABASE') . "' AND TABLE_NAME = '_master_data';"))->AUTO_INCREMENT;
        DB::table('_master_data')->where(['master' => $masters['PRICE_LIST']])->delete();
        DB::table('_master_data')->insert(SeedMasterFn([['id' => $start,'master' => $masters['PRICE_LIST'],'name' => 'Standard']]));
        DB::table('_property_masters')->where('property',$default_property_id)->delete();
        DB::table('_property_masters')->insert(SeedMasterFn([['property' => $default_property_id,'ids' => "[$start]"]]));
    }
}
