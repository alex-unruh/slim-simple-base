<?php

namespace app\tables;

use core\classes\CreateTables;
use Doctrine\DBAL\Schema\Table;

class ExampleUsersTable extends CreateTables
{

  protected $table_name = 'users';

  /**
   * Undocumented function
   *
   * @return void
   */
  public function create()
  {
    $schema = $this->conn->createSchemaManager();
    
    if ($schema->tablesExist($this->table_name)) return;
    $table = new Table($this->table_name);

    $table->addColumn('id', 'bigint', ['unsigned' => true, 'autoincrement' => true]);
    $table->addColumn('name', 'string');
    $table->addColumn('username', 'string', ['length' => 30]);
    $table->addColumn('password', 'string', ['length' => 100]);
    $table->addColumn('email', 'string');
    $table->addColumn('is_active', 'boolean');
    $table->addColumn('created_at', 'datetime');
    $table->addColumn('updated_at', 'datetime');
    $table->setPrimaryKey(['id']);

    $this->schema->createTable($table);
  }
}
