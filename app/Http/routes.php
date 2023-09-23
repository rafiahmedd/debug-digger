<?php
use DebugDigger\App\Http\Controllers\InfoController;
use DebugDigger\App\Http\Controllers\SettingController;

$router = new DebugDigger\App\Services\Router();

$router->get('site-info', [new InfoController(), 'getInfo']);
$router->get('settings', [new SettingController(), 'getSettings']);
$router->put('settings', [new SettingController(), 'updateSettings']);

$router->get('logs', [new DebugDigger\App\Http\Controllers\LogController(), 'getLog']);
$router->del('logs', [new DebugDigger\App\Http\Controllers\LogController(), 'clearLog']);