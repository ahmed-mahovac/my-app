<?php

namespace App\Exceptions;

use Exception;

class UserException extends Exception
{
    public function render($request){
        return response()->json(['message' => 'UserException has occurred.'], 500);
        // we don't want to expose stack trace etc
        // Otherwise, we can call parent::render() to get such behavior
    }
}