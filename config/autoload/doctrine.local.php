<?php
return [
    'doctrine' => [
        'connection' => [
            'orm_default' => [
                'driverClass' => \Doctrine\DBAL\Driver\PDOMySql\Driver::class,
                'params' => [
                    'host'     => 'localhost',
                    'dbname'   => 'dbname',
                    'user'     => 'root',
                    'password' => 'root',
                    'port'     => '3306',
                    'driverOptions' => [
                        1002 => 'SET NAMES utf8'
                    ]
                ]
            ],
        ],
        'entitymanager' => [
            'orm_default' => [
                'connection'    => 'orm_default',
                'configuration' => 'orm_default'
            ],
        ],
    ],
];