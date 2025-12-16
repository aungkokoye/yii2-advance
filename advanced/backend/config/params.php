<?php
return [
    'adminEmail' => 'admin@example.com',
    'uploads' => [
        'projects'      => 'uploads/projects',
        'testimonials'  => 'uploads/testimonials'
    ],
    'maxUploadFiles'                => 3,
    'maxUploadFileSize'             => 2 * 1024 * 1024, // 2MB in bytes (2,097,152 bytes)
    'allowedUploadImageExtensions'   => ['jpg', 'jpeg', 'png', 'gif']
];
