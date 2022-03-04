<?php

namespace core\logs;

class EventLog
{

  private static $log_file;

  /**
   * Undocumented function
   *
   * @param string $message
   * @param string|null $origin
   * @return void
   */
  public static function message(string $message, string $origin = null)
  {
    self::createFileIfNotExists();
    $now = date("Y-m-d H:i:s");
    $msg = $origin ? "{$now}\n{$origin}\n{$message}\n\n" : "{$now}\n{$message}\n\n";
    file_put_contents(self::$log_file, $msg, FILE_APPEND);
  }

  /**
   * Undocumented function
   *
   * @param \Exception $exception
   * @param string|null $origin
   * @return void
   */
  public static function exception(\Exception $exception, string $origin = null)
  {
    self::createFileIfNotExists();
    $now = date("Y-m-d H:i:s");
    $msg = $origin ? "{$now}\n{$origin}\n" : "{$now}\n";
    $msg .= "Message: " . $exception->getMessage() . "\nFile: " . $exception->getFile() . " | Line: " . $exception->getLine() . "\n\n";
    file_put_contents(self::$log_file, $msg, FILE_APPEND);
  }

  /**
   * Undocumented function
   *
   * @param string $message
   * @param string|null $origin
   * @return void
   */
  public static function exceptionTrace(\Exception $exception, string $origin = null)
  {
    self::createFileIfNotExists();
    $now = date("Y-m-d H:i:s");
    $msg = $origin ? "{$now}\n{$origin}\n" : "{$now}\n";
    $msg .= "Message: " . $exception->getMessage() . "\nFile: " . $exception->getFile() . " | Line: " . $exception->getLine() . "\n";
    foreach ($exception->getTrace() as $trace_line) {
      $msg .= "File: {$trace_line['file']} | Line: {$trace_line['line']} | Class: {$trace_line['class']} \n";
    }
    $msg .= "\n";
    file_put_contents(self::$log_file, $msg, FILE_APPEND);
  }

  /**
   * Create a new log file if not exists
   *
   * @return void
   */
  private static function createFileIfNotExists()
  {
    $path = $_SERVER['DOCUMENT_ROOT'] . $_ENV['BASE_PATH'] . '/logs';
    if (!is_dir($path)) mkdir($path);
    if (!is_dir($path . '/events')) mkdir(dirname($path . '/events'));
    $log_dir = dirname(__DIR__) . '/logs/events/' . date('Y_m');
    if (!is_dir($log_dir)) mkdir($log_dir);
    $file_name = $_ENV['DAILY_LOGS'] ? date('d') . '_' . 'event' : 'event';
    self::$log_file = $log_dir . '/' . $file_name . '.log';
    if (!file_exists(self::$log_file)) {
      $novo = fopen(self::$log_file, "w");
      fclose($novo);
    }
  }
}
