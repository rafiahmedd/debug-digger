<?php
function config($configName)
{
    $config = [
        'rest_api' => [
            'namespace' => 'debug-digger/v1',
            'url' => 'debug-digger/v1',
            'version' => '1',
            'nonce'     => wp_create_nonce('debug-digger'),
        ],
        'text_domain' => 'debug-digger',
    ];
    return $config[$configName];
}