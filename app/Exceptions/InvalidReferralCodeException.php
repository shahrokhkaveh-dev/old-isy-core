<?php
namespace App\Exceptions;

use Exception;

class InvalidReferralCodeException extends Exception
{
    protected $message = 'code is invalid';
    protected $code = 422;
}
