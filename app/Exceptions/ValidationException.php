<?php


namespace App\Exceptions;


use Throwable;

class ValidationException extends \Exception
{
    protected $errors;

    /**
     * AjaxValidationException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     * @param array $errors
     */
    public function __construct($errors = [], $message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
