<?php

namespace app\repositories;

use core\classes\Repository;

/**
 * Classe modelo para repositórios
 */
class ExampleRepository extends Repository
{

  protected $table_name = 'example_table';
  protected $data_types = ['user_id' => 'bigint'];
}
