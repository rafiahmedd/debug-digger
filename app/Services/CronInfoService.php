<?php
namespace DebugDigger\App\Services;

class CronInfoService
{
    public function getCronInfo()
    {
        $filteredCroneJobs = [];
        $cronJobs = _get_cron_array();
        
        foreach( $cronJobs as $timestamp => $cronJob ){
            foreach( $cronJob as $hook => $cronJob ){
                $values = array_values($cronJob)[0];
                $nextRunAndName = $this->getNextRunAndName($timestamp, $values);
                $filteredCroneJobs[$hook] = [
                    'hook' => $hook,
                    'schedule' => $values['schedule'],
                    'nextRun' => $nextRunAndName['next_run'],
                    'name' => $nextRunAndName['name'],
                    'args' => $values['args'],
                ];
            }
        }

        return [
            'cronJobs' => $filteredCroneJobs
        ];
    }

    private function getNextRunAndName($timestamp, $cronJob)
    {
        $nextRun = $timestamp;
        $schedule = $cronJob['schedule'];
        
        $schedules = wp_get_schedules();
        
        if( isset( $schedules[$schedule] ) ){
            $nextRun = strtotime( '+' . $schedules[$schedule]['interval'] . ' seconds', $timestamp );
            $nextRun = date( 'Y-m-d H:i:s', $nextRun );
            $name = $schedules[$schedule]['display'];

            return [
                'next_run' => $nextRun,
                'name' => $name,
            ];
        }
    }
}