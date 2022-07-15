<?php

namespace Milestone\Eleoi\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PricesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = 'price';
        $price_list = DB::table('_master_data')->where('master',DB::table('_masters')->where('name','PRICE_LIST')->value('id'))->value('id');
        $barcode_id = DB::table('_master_data')->where('master',DB::table('_masters')->where('name','BARCODE')->value('id'))->pluck('id','name')->toArray();
        $CONTENTS = array_map(function($line) use($price_list,$barcode_id){
            list($barcode,$price) = explode("\t",trim($line));
            return ['price_list' => $price_list,'barcode' => $barcode_id[$barcode],'price' => $price];
        },file(Storage::path(str($name)->plural()->upper()->append('.txt')->toString())));
        DB::table('prices')->where(['price_list' => $price_list])->delete();
        foreach (array_chunk(SeedMasterFn($CONTENTS),1000) as $chunk) DB::table('prices')->insert($chunk);
    }
}
