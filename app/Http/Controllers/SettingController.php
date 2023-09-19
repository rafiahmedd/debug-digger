<?php
namespace DebugDigger\App\Http\Controllers;
use DebugDigger\App\Services\SettingService;

class SettingController
{
    public function getSettings()
    {
        return [
            'data' => (new SettingService())->getSettings()
        ];
    }

    public function updateSettings($request)
    {
        return (new SettingService())->updateSettings($request->get_param('key'), $request->get_param('value'));
    }
}