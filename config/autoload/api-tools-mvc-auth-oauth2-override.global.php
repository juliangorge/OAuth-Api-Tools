<?php
return [
    'service_manager' => [
        'factories' => [
            \Laminas\ApiTools\OAuth2\Service\OAuth2Server::class => \Laminas\ApiTools\MvcAuth\Factory\NamedOAuth2ServerFactory::class,
        ],
    ],
];
