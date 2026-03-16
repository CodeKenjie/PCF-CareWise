<?php

namespace App\Core;

class Logger {
    private $logfile;

    const ERROR = "ERROR";
    const WARNING = "WARNING";
    const INFO = "INFO";
    const DEBUG = "DEBUG";

    public function __construct($filePath = __DIR__ . '/../../logs/app.log'){
        $this->logfile = $filePath;

        if(!file_exists(dirname($this->logfile))){
            mkdir(dirname($this->logfile), 0755, true);
        }
    }

    private function write($level, $message){
        $date = date('Y-m-d H:i:s');
        $logMessage = '[$date]: [$level] [$message]' . PHP_EOL;
        file_put_contents($this->logfile, $logMessage, FILE_APPEND);
    }

    public function error($message){
        $this->write(self::ERROR, $message);
    }
    public function warnign($message){
        $this->write(self::WARNING, $message);
    }
    public function info($message){
        $this->write(self::INFO, $message);
    }
    public function debug($message){
        $this->write(self::DEBUG, $message);
    }
}