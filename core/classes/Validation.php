<?php

namespace core\classes;

class Validation
{

  protected $errors = [];
  protected $throw_exceptions = false;
  protected $current_error = null;

  /**
   * Check if the errors container array has any validation errors
   *
   * @return boolean
   */
  public function hasErrors()
  {
    if (count($this->errors) > 0) return true;
    return false;
  }

  /**
   * Return the current validation error message if exists
   *
   * @return string|null
   */
  public function getError()
  {
    return $this->current_error;
  }

  /**
   * Return the array of validation errors
   *
   * @return array
   */
  public function getAllErrors()
  {
    return $this->errors;
  }

  /**
   * Undocumented function
   *
   * @param boolean $throw
   * @return void
   */
  public function throwExceptions($throw = true)
  {
    $this->throw_exceptions = $throw;
  }

  /**
   * Add an error to array errors container array and set the current error property
   *
   * @param string $msg
   * @return void
   */
  protected function setError($msg)
  {
    $this->current_error = $msg;
    array_push($this->errors, $msg);
    if ($this->throw_exceptions) throw new \InvalidArgumentException($msg, 422);
  }
}
