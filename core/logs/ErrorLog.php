<?php

namespace core\logs;

use Slim\Handlers\ErrorHandler;

/**
 * Errors log management class
 */
class ErrorLog extends ErrorHandler
{

  private $log_file;

  /**
   * Overwrites the method from ErrorHandler
   *
   * @param string $error
   * @return void
   */
  protected function logError(string $error): void
  {
    $message = str_replace("Slim Application Error", $_ENV['APP_NAME'] . ' error:', $error);
    if ($this->statusCode === 404 || $this->statusCode === 422 || $this->statusCode === 400) return;
    $this->createFileIfNotExists();
    $now = date("Y-m-d H:i:s");
    file_put_contents($this->log_file, "{$now}\n$message\n\n", FILE_APPEND);
  }

  /**
   * Create a new log file if not exists
   *
   * @return void
   */
  private function createFileIfNotExists()
  {
    $path = $_SERVER['DOCUMENT_ROOT'] . $_ENV['BASE_PATH'] . '/logs';
    if (!is_dir($path)) mkdir($path);
    if (!is_dir($path . '/errors')) mkdir($path . '/errors');
    $log_dir = $path . '/errors/' . date('Y_m');
    if (!is_dir($log_dir)) mkdir($log_dir);

    $file_name = $_ENV['DAILY_LOGS'] ? date('d') . '_' . 'error' : 'error';
    $this->log_file = $log_dir . '/' . $file_name . '.log';
    if (!file_exists($this->log_file)) {
      $novo = fopen($this->log_file, "w");
      fclose($novo);
    }
  }
}
