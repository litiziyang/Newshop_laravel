<?php


namespace App\Exceptions;


use Throwable;

class TestException extends \Exception
{
    public function __construct($message )
    {
        parent::__construct($message);
    }


}
