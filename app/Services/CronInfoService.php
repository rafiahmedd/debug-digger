<?php
namespace DebugDigger\App\Services;

class CronInfoService
{
    /**
     * Get cron info from WordPress and return it
     * @return array
     */
    public function getCronInfo()
    {
        $filteredCroneJobs = [];
        $cronJobs = _get_cron_array(); // Get all cron jobs
        
        foreach( $cronJobs as $timestamp => $cronJob ){
            foreach( $cronJob as $hook => $cronJob ){
                $values = array_values($cronJob)[0];
                $nextRunAndName = $this->getNextRunAndName($timestamp, $values);
                $filteredCroneJobs[$hook] = [
                    'hook' => $hook,
                    'schedule' => $values['schedule'],
                    'nextRun' => $nextRunAndName['next_run'].' ('.$this->diffTimeFromNow($nextRunAndName['next_run']).')',
                    'name' => $nextRunAndName['name'],
                    'args' => $values['args'],
                ];
            }
        }

        $cron_jobs = wp_get_ready_cron_jobs(); // Get only ready cron jobs
        

        return [
            'cronJobs' => $filteredCroneJobs,
            'readyCron' => $cron_jobs,
        ];
    }

    // Get next run and name of cron job
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
                'next_run' => esc_html($nextRun),
                'name' => esc_html($name),
            ];
        }
    }

    // Calculate time difference from now
    private function diffTimeFromNow($nextRun)
    {
        $currentTime = date("Y-m-d H:i:s", time());
        $timeDiff = strtotime($nextRun) - strtotime($currentTime);
        $hours = intval($timeDiff/3600);
        $minutes = intval(($timeDiff / 60)) % 60;
        $seconds = $timeDiff % 60;
        
         return esc_html($hours . ' hours ' . $minutes . ' minutes ' . $seconds . ' seconds');
    }
}