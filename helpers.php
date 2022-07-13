<?php

use \Illuminate\Support\Facades\Cache;
use \Illuminate\Support\Facades\DB;
use \Illuminate\Support\Arr;
use \Illuminate\Support\Carbon;

if(!function_exists('eleoi_config')) {
    function eleoi_config($key, $default = null) {
        return env('eleoi_' . $key, config('eleoi.' . $key, $default));
    }
}

function SeedMasterFn($contents,$additional = [],$column = 'name'):array {
    $created_at = $updated_at = now()->toDateTimeString();
    $merge = array_merge($additional,compact('created_at','updated_at'));
    return array_map(fn($name) => is_array($name) ? array_merge($name,$merge) : array_merge([$column => $name],$merge),$contents);
}

if(!function_exists('db_masters')){
    function db_masters(){
        return Cache::rememberForever(eleoi_config('cache_key.db_masters'),fn() => DB::table('_masters')->pluck('name','id')->toArray());
    }
}
if(!function_exists('db_master_data_time')) {
    function db_master_data_time(){
        return Cache::rememberForever(eleoi_config('cache_key.db_master_data_max'), fn() => DB::table('_master_data')->select(['master', DB::raw('max(updated_at) as `max`')])->groupBy('master')->pluck('max', 'master')->toArray());
    }
}
if(!function_exists('db_master_data')) {
    function db_master_data($master = null) {
        return Arr::get(Cache::rememberForever(eleoi_config('cache_key.db_master_data'), fn() => DB::table('_master_data')->get()->groupBy->master->map(fn($masters) => $masters->map(fn($master) => [intval($master->id), trim($master->name)]))->toArray()), $master,[]);
    }
}
if(!function_exists('db_properties_last_updated')) {
    function db_properties_last_updated() {
        return Cache::rememberForever(eleoi_config('cache_key.db_properties_last_updated_time'),fn() => max(Carbon::parse(DB::table('_property_masters')->max('updated_at'))->unix(),Carbon::parse(DB::table('_properties')->max('updated_at'))->unix()));
    }
}
