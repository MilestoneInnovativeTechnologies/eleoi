<?php

return [

    /*
    |--------------------------------------------------------------------------
    | db_masters_cache_key
    |--------------------------------------------------------------------------
    |
    | This value decides in what variable name the applications masters to be saved
    | Whenever an update occurs in this db table, this cache will also get refreshed
    |
    */

    'db_masters_cache_key'  =>  'DB_MASTERS',

    /*
    |--------------------------------------------------------------------------
    | db_master_data_max_cache_key
    |--------------------------------------------------------------------------
    |
    | This value decides in what variable name the master data maximum updated time to be stored
    | Whenever an update occurs in this db table, this cache will also get refreshed
    |
    */

    'db_master_data_max_cache_key'  =>  'DB_MASTER_DATA_MAX',
];