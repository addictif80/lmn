<?php

return [
    'telescope' => [
        'driver' => 'file',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
    ],
];
