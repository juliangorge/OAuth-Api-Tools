<?php

use Laminas\Http\Client as HttpClient;

return [
    'apigility-consumer' => [
        'api-host-url' => 'http://api.edoctor.test',

        // null for default or array of configuration listed at https://docs.zendframework.com/zend-http/client/intro/#configuration
        'http_client_options' => null,

        // for oauth
        'oauth' => [

            //default selected client
            'grant_type'    => 'password', // or client_credentials
            'client_id'     => 'testclient2',
            'client_secret' => '',

            // multiple clients to be selected
            'clients' => [
                'testclient' => [ // foo is client_id
                    'grant_type'    => 'password', // or client_credentials
                    'client_secret' => 'testpass',
                ],
                'testclient2' => [ // bar is client_id
                    'grant_type'    => 'password', // or client_credentials
                    'client_secret' => '',
                ],
            ],

        ],

        // for basic and or digest
        /*'auth' => [

            // default client
            HttpClient::AUTH_BASIC => [
                'username' => 'foo',
                'password' => 'foo_s3cret'
            ],

            HttpClient::AUTH_DIGEST => [
                'username' => 'foo',
                'password' => 'foo_s3cret'
            ],

            // multiple clients to be selected
            'clients' => [
                'foo' => [ // foo is key represent just like "client_id" to ease switch per-client config
                    HttpClient::AUTH_BASIC => [
                        'username' => 'foo',
                        'password' => 'foo_s3cret'
                    ],

                    HttpClient::AUTH_DIGEST => [
                        'username' => 'foo',
                        'password' => 'foo_s3cret'
                    ],
                ],
                'bar' => [ // bar is key represent just like "client_id" to ease switch per-client config
                    HttpClient::AUTH_BASIC => [
                        'username' => 'bar',
                        'password' => 'bar_s3cret'
                    ],

                    HttpClient::AUTH_DIGEST => [
                        'username' => 'bar',
                        'password' => 'bar_s3cret'
                    ],
                ],
            ],

        ],*/
    ],
];