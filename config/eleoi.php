<?php

return [

    /*
    |--------------------------------------------------------------------------
    | cache_key
    |--------------------------------------------------------------------------
    |
    | These value decides in what variable name the application's master data and time to be stored
    | Whenever an update occurs in corresponding db table, corresponding cache will also get refreshed
    |
    */

    'cache_key' => [
        'db_masters'  =>  'DB_MASTERS',
        'db_master_data_max_times'  =>  'DB_MASTER_DATA_MAX_TIME',
        'db_properties'  =>  'DB_PROPERTIES',
        'db_master_data'  =>  'DB_MASTER_DATA',
        'db_properties_last_updated_time'  =>  'DB_PROPERTIES_LAST_UPDATED_TIME',
    ],
];