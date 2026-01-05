<?php

class Logger
{
  
    public static function log(string $message, string $level = 'INFO'): void
    {
        
        $logDir = BASE_PATH . '/logs';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        // logLine & timestamp
        $timestamp = date('Y-m-d H:i:s');
        $logLine = "[$timestamp] [$level] $message\n";

        // Append to file
        if($level === "INFO"){
            file_put_contents($logDir . '/info.log', $logLine, FILE_APPEND);

        }else{
            file_put_contents($logDir . '/errors.log', $logLine, FILE_APPEND);

        }
    }
}
