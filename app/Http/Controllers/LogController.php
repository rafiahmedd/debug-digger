<?php
namespace DebugDigger\App\Http\Controllers;
use DebugDigger\App\Services\LogService;

class LogController
{
    public function getLog()
    {
        try{
            return (new LogService())->getLog();
        } catch(\Exception $e){
            return [
                'error' => $e->getMessage()
            ];
        }
    }

    public function clearLog()
    {
        try{
            return (new LogService())->clearLog();
        } catch(\Exception $e){
            return [
                'error' => $e->getMessage()
            ];
        }
    }
}