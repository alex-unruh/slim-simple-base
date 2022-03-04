<?php

namespace app\validations;

use core\classes\Validation;

/**
 * Classe modelo para lógicas de validação
 */
class ExampleValidation extends Validation
{

  /**
   * Check is a value exists and is not empty
   *
   * @param string $value
   * @return boolean
   */
  public function validate($value = null): bool
  {
    if (!$value || empty(trim($value))) {
      $this->setError('Incorrect value');
      return false;
    }
    return true;
  }
}
