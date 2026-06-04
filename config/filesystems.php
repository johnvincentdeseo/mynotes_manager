<?php

return [

    'default' => env('FILESYSTEM_DISK', 'public'), // Change to 'public' so it's used by default

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        // UPDATED: Pointing directly to a folder inside /public
        'public' => [
            'driver' => 'local',
            'root' => public_path('uploads'), 
            'url' => env('APP_URL') . '/uploads',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            // ... (keep your existing S3 config)
        ],

    ],

    'links' => [], // Leave empty: Symbolic links do not work on InfinityFree

];
