<?php

return [

    'upload' => [
        'path' => __DIR__ . getenv('UPLOAD_PATH'),
        'folder' => [
            'name' => getenv('UPLOAD_FOLDER_NAME')
        ]
    ]

];