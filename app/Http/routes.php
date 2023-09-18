<?php

$router = new DebugDigger\App\Services\Router();

use DebugDigger\App\Http\Controllers\TestController;

$router->get('test', [new TestController(), 'test']);