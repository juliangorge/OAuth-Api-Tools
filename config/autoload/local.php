<?php
return [
    'cryptoKey' => 'SOME SUPER SECRET PASSPHRASE HERE THAT YOU JUST MADE UP',
    'hybridauth' => [
        'providers' => [
            'google' => [
                'enabled' => true,
                'keys' => [
                    'id' => 'YOUR GOOGLE CLIENT ID',
                    'secret' => 'YOUR GOOGLE CLIENT SECRET',
                ],
            ],
            'facebook' => [
                'enabled' => true,
                'keys' => [
                    'id' => 'id',
                    'secret' => 'secret',
                ],
                'scope' => 'email, public_profile',
            ],
        ],
    ],
    'api-tools-mvc-auth' => [
        'authentication' => [
            'map' => [
                'DbApi\\V1' => 'client',
                'Laminas\\ApiTools\\OAuth2' => 'session',
            ],
            'adapters' => [
                'client' => [
                    'adapter' => \Laminas\ApiTools\MvcAuth\Authentication\OAuth2Adapter::class,
                    'storage' => [
                        'adapter' => \pdo::class,
                        'dsn' => 'mysql:host=localhost;dbname=dbname',
                        'route' => '/oauth',
                        'username' => 'root',
                        'password' => 'root',
                        'options' => [
                            1002 => 'SET NAMES utf8',
                        ],
                    ],
                ],
                'session' => [
                    'adapter' => \Application\Authentication\Adapter\SessionAdapter::class,
                ],
                'user' => [
                    'adapter' => \Application\Authentication\Adapter\SessionAdapter::class,
                    'storage' => [
                        0 => 'Application\\Authentication\\Storage\\Session',
                    ],
                ],
            ],
            'options' => [
                'always_issue_new_refresh_token' => true,
            ],
        ],
    ],
    'api-tools-oauth2' => [
        'allow_implicit' => true,
    ],
    'db' => [
        'adapters' => [
            'dummy' => [
                'database' => 'dbname',
                'driver' => 'PDO_Mysql',
                'hostname' => 'localhost',
                'username' => 'root',
                'password' => 'root',
            ],
        ],
    ],
];
