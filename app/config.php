<?php
function config($configName)
{
    $config = [
        'rest_api' => [
            'namespace' => 'debug-digger/v1',
            'url' => 'debug-digger/v1',
            'version' => '1',
            'nonce'     => 'wp_rest',
        ],
        'text_domain' => 'debug-digger',
    ];
    return $config[$configName];
}