<?php

function SeedMasterFn($contents,$additional = [],$column = 'name'):array {
    $created_at = $updated_at = now()->toDateTimeString();
    $merge = array_merge($additional,compact('created_at','updated_at'));
    return array_map(fn($name) => is_array($name) ? array_merge($name,$merge) : array_merge([$column => $name],$merge),$contents);
}
