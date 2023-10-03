<?php
namespace DebugDigger\App\Services;

class LogService
{
    private array $logs;
    private $logData;

    public function __construct()
    {
        $this->logData = file_get_contents(ABSPATH . 'wp-content/debug.log');
    }
    public function getLog()
    {
        $this->logData = file_get_contents(ABSPATH . 'wp-content/debug.log');

        if (empty($this->logData)) {
            return [
                'log' => []
            ];
        }

        $logLines = explode("\n", $this->logData);

        foreach ($logLines as $index => $line) {
            $pattern = '/\[(.*?)\] (PHP (?:Warning|Notice|Fatal error|Parse error|(?:\w+ )?Exception)): (.+) in (.+) on line (\d+)/';
            if (preg_match($pattern, $line, $matches)) {
                $this->buildLog($matches, $index);
            }
        }

        return [
            'log' => array_reverse($this->logs)
        ];
    }

    // clear log
    public function clearLog()
    {
        file_put_contents($this->logFilePath, '');
    }

    private function buildLog($matches, $index)
    {
        $errorTime = $matches[1];
        $errorType = $matches[2];
        $errorDescription = $matches[3];
        $errorFile = $matches[4];
        $lineNumber = $matches[5];

        $this->logs[$index] = [
            'errorType' => $errorType = preg_replace('/^PHP /', '', $errorType),
            'errorTime' => $errorTime,
            'errorFile' => $errorFile,
            'errorDescription' => $errorDescription,
            'lineNumber' => $lineNumber,
        ];
    }
}