<?php

return [
    'pdf' => [
        'enabled' => true,
        'binary'  => env('WKHTMLTOPDF_PATH', '/usr/local/bin/wkhtmltopdf'),
        // Untuk Windows:
        // 'binary' => base_path('vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),

        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true, // PENTING untuk gambar
            'no-background' => true,
            'print-media-type' => true,
            'disable-smart-shrinking' => true,
            'dpi' => 300,
        ],
        'env'     => [],
    ],

    'image' => [
        'enabled' => true,
        'binary'  => env('WKHTMLTOIMAGE_PATH', '/usr/local/bin/wkhtmltoimage'),
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],
];
