<?php

require_once __DIR__ . '/bootstrap/app.php';

return [
 	
    'paths' => [
        'migrations' => 'database/migrations',
        'seeds' => 'database/seeds'
    ],

    'migration_base_class' => 'Base\Database\Migrations\Migration',

    'templates' => [
        'file' => 'app/Database/Migrations/MigrationStub.php'
    ],

    'environments' => [
        'default_migration_table' => '_migrations',
        'default' => [
            'adapter' => $container->config->get('database.driver'),
            'host' => $container->config->get('database.host'),
            'port' => $container->config->get('database.port'),
            'name' => $container->config->get('database.database'),
            'user' => $container->config->get('database.username'),
            'pass' => $container->config->get('database.password')
        ]
    ]

];