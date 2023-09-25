<?php
namespace DebugDigger\App\Http\Controllers;
use DebugDigger\App\Services\CronInfoService;
class CronInfoController
{
    public function getCronInfo()
    {
        try{
            return (new CronInfoService())->getCronInfo();
        } catch(\Exception $e){
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}