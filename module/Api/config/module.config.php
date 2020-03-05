<?php
return [
    'controllers' => [
        'factories' => [
            'Api\\V1\\Rpc\\HybridAuth\\Controller' => \Api\V1\Rpc\HybridAuth\HybridAuthControllerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'e-doctor.rpc.hybrid-auth' => [
                'type' => 'Segment',
                'options' => [
                    'route' => '/hybridauth[/:action]',
                    'defaults' => [
                        'controller' => 'Api\\V1\\Rpc\\HybridAuth\\Controller',
                        'action' => 'hybridAuth',
                    ],
                ],
            ],
        ],
    ],
    'api-tools-versioning' => [
        'uri' => [
            0 => 'e-doctor.rpc.hybrid-auth',
        ],
    ],
    'api-tools-rpc' => [
        'Api\\V1\\Rpc\\HybridAuth\\Controller' => [
            'service_name' => 'HybridAuth',
            'http_methods' => [
                0 => 'GET',
            ],
            'route_name' => 'e-doctor.rpc.hybrid-auth',
        ],
    ],
    'api-tools-content-negotiation' => [
        'controllers' => [
            'Api\\V1\\Rpc\\HybridAuth\\Controller' => 'HalJson',
        ],
        'accept_whitelist' => [
            'Api\\V1\\Rpc\\HybridAuth\\Controller' => [
                0 => 'application/vnd.e-doctor.v1+json',
                1 => 'application/json',
                2 => 'application/*+json',
            ],
        ],
        'content_type_whitelist' => [
            'Api\\V1\\Rpc\\HybridAuth\\Controller' => [
                0 => 'application/vnd.e-doctor.v1+json',
                1 => 'application/json',
            ],
        ],
    ],
    'service_manager' => [
        'factories' => [],
    ],
    'api-tools-rest' => [],
    'api-tools-hal' => [
        'metadata_map' => [],
    ],
    'api-tools-mvc-auth' => [
        'authorization' => [],
    ],
    'api-tools-content-validation' => [],
    'input_filter_specs' => [
        'Api\\V1\\Rpc\\Users\\Validator' => [
            0 => [
                'required' => true,
                'validators' => [],
                'filters' => [],
                'name' => 'Ack',
                'description' => 'Acknownledge',
            ],
        ],
    ],
];
