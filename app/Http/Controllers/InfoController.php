<?php
namespace DebugDigger\App\Http\Controllers;

class InfoController
{
    public function getInfo()
    {
        return [
            'data' => [
                'php_version' => phpversion(),
                'wp_version' => get_bloginfo('version'),
                'php_extensions' => get_loaded_extensions(),
                'php_configuration' => ini_get_all(),
                'server' => $_SERVER,
            ]
        ];
    }
}