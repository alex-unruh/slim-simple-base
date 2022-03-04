<?php

namespace core\helpers;

/**
 * Helper to obtain connection information
 */
class ConnectionHelper
{

  private static $drivers = [1 => 'pdo_mysql', 2 => 'pdo_sqlsrv', 3 => 'pdo_pgsql', 4 => 'pdo_sqlite', 5 => 'pdo_oci', 6 => 'mysqli', 7 => 'sqlsrv', 8 => 'oci8'];

  /**
   * Return the default connection params
   *
   * @return null|array
   */
  public static function getParams()
  {
    if (!self::hasConnectionParams()) return null;
    $params =  ['host' => $_ENV['DB_HOST'], 'dbname' => $_ENV['DB_NAME'], 'user' => $_ENV['DB_USER']];
    $params += ['password' => $_ENV['DB_PASS'], 'driver' => $_ENV['DB_DRIVER'], 'port' => $_ENV['DB_PORT'], 'charset' => $_ENV['DB_CHARSET']];
    return $params;
  }

  /**
   * Return the driver index by driver name. 
   *
   * @param string|null $driver_name
   * @return integer If driver name is not passed, returns the default connection driver index
   */
  public static function getDriverIndex(string $driver_name = null): int
  {
    if ($driver_name) return array_search($driver_name, self::$drivers);
    return array_search($_ENV['DB_DRIVER'], self::$drivers);
  }

  /**
   * Return the driver name by index
   *
   * @param integer|null $driver_index
   * @return string If driver index is not passed, returns the default connection driver name
   */
  public static function getDriverName(int $driver_index = null): string
  {
    if ($driver_index) return self::$drivers[$driver_index];
    return $_ENV['DB_DRIVER'];
  }

  /**
   * Check if there are active connection parameters
   *
   * @return boolean
   */
  public static function hasConnectionParams()
  {
    $params = ['DB_HOST', 'DB_NAME', 'DB_USER', 'DB_DRIVER'];
    foreach ($params as $param) {
      if (!isset($_ENV[$param])) return false;
    }
    return true;
  }
}
