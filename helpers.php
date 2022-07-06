<?php

function SeedMasterFn($contents,$additional = [],$column = 'name'):array {
    $created_at = $updated_at = now()->toDateTimeString();
    $merge = array_merge($additional,compact('created_at','updated_at'));
    return array_map(fn($name) => is_array($name) ? array_merge($name,$merge) : array_merge([$column => $name],$merge),$contents);
}

function master_asset_js_route_params($id):array {
    $masters = \Illuminate\Support\Facades\Cache::rememberForever(eleoi_config('db_masters_cache_key'),function(){ return \Illuminate\Support\Facades\DB::table('_masters')->pluck('name','id')->toArray(); });
    $db_max = \Illuminate\Support\Facades\Cache::rememberForever(eleoi_config('db_master_data_max_cache_key'),function(){ return \Illuminate\Support\Facades\DB::table('_master_data')->select(['master',\Illuminate\Support\Facades\DB::raw('max(updated_at) as `max`')])->groupBy('master')->pluck('max','master')->toArray(); });
    return [\Illuminate\Support\Carbon::parse($db_max[$id] ?? '2000-01-01 00:00:01')->unix(),str($masters[$id] ?? 'NONE')->trim()->lower()->snake()->upper()->toString()];
}

function eleoi_config($key,$default = null){
    return env('eleoi_' . $key,config('eleoi.' . $key,$default));
}