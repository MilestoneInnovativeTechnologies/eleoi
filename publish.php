<?php

exec('DEL /Q /S milestone\\eleoi\\public\\assets\\*.*');
exec('XCOPY dist\\spa\\assets milestone\\eleoi\\public\\assets /EHRYI');

exec('XCOPY src milestone\\eleoi\\install\\src /EHRYI');

$json = [];
preg_match_all('/(href|src)="\/assets\/index\.(.{8})\.(css|js)/',file_get_contents(implode(DIRECTORY_SEPARATOR,[__DIR__,'..','..','dist','spa','index.html'])),$matches);
foreach ($matches[3] as $idx => $ext){
  if(!array_key_exists($ext,$json)) $json[$ext] = [];
  if(!in_array($matches[2][$idx],$json[$ext])) $json[$ext][] =  $matches[2][$idx];
}
file_put_contents(implode(DIRECTORY_SEPARATOR,[__DIR__,'public','assets.json']),json_encode($json));

exec('XCOPY "' . implode(DIRECTORY_SEPARATOR,[__DIR__,'public']) . '" "' . implode(DIRECTORY_SEPARATOR,[__DIR__,'..','..','public']) . '" /EHRYI');
