<?php
namespace utils;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as MonlogLogger;

class Logger
{
    private static $_pid = null;

    /**
     * @var MonlogLogger
     */
    private static $_monitorLogger = null;

    private static function _initMonitorLogger()
    {
        self::$_monitorLogger = new MonlogLogger('monitor');
        $logFile        = self::_getBasePath() . '/monitor_' . date('Ymd') . '.log';
        $streamHandler  = new StreamHandler($logFile, MonlogLogger::DEBUG, true, 0777);
        $streamHandler->setFormatter(self::_getFormatter());
        self::$_monitorLogger->pushHandler($streamHandler);
    }

    /**
     * 错误
     */
    public static function error($sign, $message, $context = [])
    {
        if (self::$_monitorLogger == null) {
            self::_initMonitorLogger();
        }
        self::$_monitorLogger->addError($message, self::_getContextInfo($sign, $context));
        return true;
    }

    /**
     * 致命异常
     */
    public static function fatal($sign, $message, $context = [])
    {
        if (self::$_monitorLogger == null) {
            self::_initMonitorLogger();
        }
        self::$_monitorLogger->addError($message, self::_getContextInfo($sign, $context));
        return true;
    }

    /**
     * 警告
     */
    public static function warning($sign, $message, $context = [])
    {
        if (self::$_monitorLogger == null) {
            self::_initMonitorLogger();
        }
        self::$_monitorLogger->addWarning($message, self::_getContextInfo($sign, $context));
        return true;
    }

    /**
     * 提醒
     */
    public static function notice($sign, $message, $context = [])
    {
        if (self::$_monitorLogger == null) {
            self::_initMonitorLogger();
        }
        self::$_monitorLogger->addNotice($message, self::_getContextInfo($sign, $context));
        return true;
    }

    /**
     * Debug
     */
    public static function debug($sign, $message, $context = [])
    {
        if (self::$_monitorLogger == null) {
            self::_initMonitorLogger();
        }
        self::$_monitorLogger->addDebug($message, self::_getContextInfo($sign, $context));
        return true;
    }

    private static function _getContextInfo($sign, $contexts)
    {
        if (!is_array($contexts)) {
            $contexts = [$contexts];
        }
        $callMessage        = self::_getCallerMessage();
        $contexts['pid']    = self::_getPid();
        $contexts['sign']   = $sign;
        $contexts['callMessage'] = $callMessage;

        return $contexts;
    }

    private static function _getFormatter()
    {
        $dateFormat = "Y-m-d H:i:s";
        $output     = "%datetime%[%level_name%][%context.sign%:%message%][%context.pid%][%context%][%context.callMessage%]\n";
        $formatter  = new LineFormatter($output, $dateFormat);
        return $formatter;
    }

    private static function _getBasePath()
    {
        $config = \Yaf_Application::app()->getConfig();
        $path   = $config->application->log_path;
        return $path;
    }

    private static function _getPid()
    {
        if (self::$_pid == null) {
            self::$_pid = 'pid:' . time() . rand(1000, 9999);
        }
        return self::$_pid;
    }

    private static function _getCallerMessage()
    {
        $debugInfos     = debug_backtrace();
        $callMessage    = '';
        foreach($debugInfos as $debugInfo) {
            if (strpos($debugInfo['file'], 'utils/Logger.php') === false) {
                $file       = $debugInfo['file'];
                $line       = $debugInfo['line'];
                $function   = $debugInfo['function'];
                $class      = $debugInfo['class'];
                $files      = explode('application', $file);
                $file       = $files[count($files)-1];
                $callMessage = $file . ':' . $line . ' -> ' . $class . '::' . $function;
                break;
            }
        }
        return $callMessage;
    }
}