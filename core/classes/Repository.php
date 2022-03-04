<?php

namespace core\classes;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Types\Type;

/**
 * An abstraction database layer built around the Doctrine DBAL SQL Query Builder
 * Se more information in: https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/index.html
 * 
 * @author Alexandre Unruh <alexandre@unruh.com.br>
 * @license MIT
 */
class Repository extends QueryBuilder
{

  protected $table_name = null;
  protected $table_alias = null;
  protected $data_types = [];
  protected $statement_params = [];
  protected $connection_params = null;

  public function __construct(array $connection_params = null)
  {
    if (!$connection_params) return;
    $connection = DriverManager::getConnection($connection_params);
    parent::__construct($connection);
  }

  /**
   * Undocumented function
   *
   * @param Connection $connection
   * @return Repository
   */
  public function setConnection(Connection $connection): Repository
  {
    parent::__construct($connection);
    return $this;
  }

  /**
   * Set the types of data to be binded in bindParams
   * Nedd to have an array with the respective pairs of key and value. eg. ['name' => 'string', 'created_at' => 'datetime', ...]
   *
   * @param array $types
   * @return Repository
   */
  public function setTypes(array $types): Repository
  {
    $this->data_types = $types;
    return $this;
  }

  /**
   * Undocumented function
   *
   * @return mixed $result
   */
  public function get()
  {
    return $this->executeQuery()->fetchAllAssociative();
  }

  /**
   * Undocumented function
   *
   * @return mixed $result
   */
  public function getFirst()
  {
    return $this->executeQuery()->fetchAssociative();
  }

  /**
   * Must be used to execute a statement initialized by update ou delete methods
   *
   * @return integer
   */
  public function execute(): int
  {
    $this->bindParams();
    $result = $this->executeStatement();
    return $result;
  }

  /**
   * Prepare the SQL statement in insert method
   *
   * @param array $data
   * @return Repository
   */
  public function addValues(array $data): Repository
  {
    foreach ($data as $key => $val) {
      $this->statement_params[$key] = $val;
      $this->setValue($key, ":{$key}");
    }
    return $this;
  }

  /**
   * Prepare the SQL statement in update method
   * Shold not be used within updates with joins
   *
   * @param array $data
   * @param boolean|null $update
   * @return Repository
   */
  public function setValues(array $data): Repository
  {
    foreach ($data as $key => $val) {
      $this->statement_params[$key] = $val;
      $this->set($key, ":{$key}");
    }
    return $this;
  }

  /**
   * Select data in a database table. Shold be used only in children classes.
   * Need's a table name defined before. 
   *
   * @param array $data
   * @param string|null $table_alias
   * @return Repository
   */
  public function read(array $data, string $table_alias = null): Repository
  {
    $columns = implode(', ', $data);
    $this->select($columns)->from($this->table_name, $table_alias);
    return $this;
  }

  /**
   * Create a new record in a dabatase table. Shold be used only in children classes.
   * Need's a table name defined before.
   *
   * @param array $data
   * @return Repository
   */
  public function create(array $data): Repository
  {
    $this->insert($this->table_name)->addValues($data);
    return $this;
  }

  /**
   * Update a set of culumns in database. Shold be used only in children classes.
   * Need's a table name defined before. Be careful! Use ever with where statement
   *
   * @param array $data
   * @param string|null $table_alias
   * @return Repository
   */
  public function modify(array $data, string $table_alias = null): Repository
  {
    $this->update($this->table_name, $table_alias)->setValues($data);
    return $this;
  }

  /**
   * Delete record(s) in a database table, Shold be used only in children classes.
   * Need's a table name defined before. Be careful! Use ever with where statement
   *
   * @param string|null $table_alias
   * @return Repository
   */
  public function destroy(string $table_alias = null): Repository
  {
    $this->delete($this->table_name, $table_alias);
    return $this;
  }

  /**
   * Make the bind params. Must be called before execute the query
   *
   * @return void
   */
  protected function bindParams()
  {
    $sv = $this->statement_params;
    foreach ($sv as $key => $val) {
      if (!isset($this->data_types[$key])) $this->setParameter($key, $val);
      else $this->setParameter($key, $val, Type::getType($this->data_types[$key]));
    }
  }
}
