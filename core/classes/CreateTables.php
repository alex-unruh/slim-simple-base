<?php

namespace core\classes;

use core\helpers\ConnectionHelper;
use Doctrine\DBAL\DriverManager;

class CreateTables
{

  protected $conn = null;
  protected $table_name = null;
  protected $connection_params = null;

  public function __construct($connection_params = null)
  {
    $this->connection_params = $connection_params ?? ConnectionHelper::getParams();
    $this->getConnection();
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  protected function getConnection()
  {
    $this->conn = DriverManager::getConnection($this->connection_params);
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  protected function getQueryBuilder()
  {
    return $this->conn->getQueryBuilder();
  }

  /**
   * Undocumented function
   *
   * @return void
   */
  protected function getSchemaManager()
  {
    return $this->conn->createSchemaManager();
  }
}
