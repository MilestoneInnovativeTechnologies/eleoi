<?php

namespace Milestone\Eleoi\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AssetController extends Controller
{
    public function init(){
        $masters = json_encode(db_masters());
        $prop_time = db_properties_last_updated();
        $master_time = json_encode(Arr::map(db_master_data_time(),fn($max) => Carbon::parse($max)->unix()));
        $script = <<<SCRIPT
const MASTERS = $masters;
AssetWorker = new Worker('AssetWorker.js');
AssetWorker.postMessage({ type:'init',payload:{ masters:$masters,property_time:$prop_time,master_time:$master_time } });
SCRIPT;
        return response($script)->withHeaders(["Cache-Control" => "no-cache, must-revalidate, no-store, max-age=0, private"]);
    }

    public function properties($time) {
        $properties = Cache::rememberForever(eleoi_config('cache_key.db_properties'),function(){
            return DB::table('_properties')->get()->groupBy->master->map(function($props){ return $props->map(fn($prop) => Arr::except((array) $prop,['master','created_at','updated_at'])); })->toArray();
        });
        $m_pis = collect($properties)->flatten(1)->map(fn($property) => $property['index'] === 'Y' ? $property['id'] : null)->filter()->values()->toArray();
        $properties_masters = DB::table('_property_masters')
            ->whereIn('property',$m_pis)
            ->get(['property','value','data','ids'])
            ->map(function($row){
                $row->data = $row->data ? intval($row->data) : null;
                $row->ids = json_decode($row->ids,true);
                return (array) $row;
            })
            ->groupBy('property')
            ->toArray();
        $merged_properties = [];
        foreach ($properties as $master => $m_properties){
            if(!in_array($master,$merged_properties)) $merged_properties[$master] = [];
            foreach ($m_properties as $idx => $property){
                $merged_properties[$master][$idx] = $property;
                if($property['index'] === 'Y' && Arr::has($properties_masters,$property['id'])) {
                    $masters = Arr::get($properties_masters,$property['id']);
                    $merged_properties[$master][$idx]['masters'] = array_map(fn($master) => Arr::except($master,'property'),$masters);
                }
            }
        }
        return $merged_properties;
    }

    public function master($time,$id,$name) {
        return db_master_data($id);
    }

    public function master_properties($id,$name) {
        $properties = Arr::get(Cache::get(eleoi_config('cache_key.db_properties')),$id,[]);
        $property_ids = empty($properties) ? [] : array_values(array_column($properties,'id'));
        return DB::table('_master_properties')->whereIn('property',$property_ids)->get()->groupBy->property->map(fn($rows) => $rows->groupBy->data->map(fn($rows2) => array_column($rows2->toArray(),'value')));
    }
}
