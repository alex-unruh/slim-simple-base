<?php

namespace core\helpers;

/**
 * Class to date management
 */
class DateHelper
{

  /**
   * Validate date formats
   *
   * @param string $date to check
   * @param string $format to compare
   * @return boolean
   */
  public static function validateFormat(string $date, string $format = 'Y-m-d'): bool
  {
    $d = \DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
  }

  /**
   * Retorna um valor default para datas "zeradas" de acordo com o tipo de bancos de dados
   *
   * @param int $sgbd_tipo [1 => MySQL, 2 => SQL Server]
   * @return string
   */
  public static function getDefaultByConnectionType($sgbd_type)
  {
    if ((int) $sgbd_type === 1) {
      return '0000-00-00 00:00:00';
    }

    return '1900-01-01 00:00:00.000';
  }

  /**
   * Convert string dates to int values
   *
   * @param string $date date to convert
   * @param string $format date input format
   * @return integer
   */
  public static function convertToInt($date, $format = 'Y-m-d'): int
  {
    $new_date = \DateTime::createFromFormat($format, $date);
    $date = $new_date->format('ymd');
    if (!$date) return 0;
    $day = $month = $year = 0;
    $date = preg_replace('#[^0-9]+$#', '', $date);
    if (empty($date)) return 0;
    $date_size = strlen($date);
    $move = ($date_size - 6);
    $year = intval(substr($date, 0, 2 + $move));
    $month = intval(substr($date, 2 + $move, 2));
    $$day = intval(substr($date, 4 + $move, 2));
    if ($date_size == 6) {
      if ($year > 80) $year -= 80;
      else $year += 20;
    } else {
      $year -= 1980;
    }
    $year <<= 9;
    $month <<= 5;
    return (intval($$day | $month | $year));
  }
}
