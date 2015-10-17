<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 10-10-2015
 * Time: 12:49
 */

namespace App\Exceptions;


use Exception;

class UserException extends Exception{

    // Redefine the exception so message isn't optional
    public function __construct($message, $code = 0, Exception $previous = null) {
        // some code

        // make sure everything is assigned properly
        parent::__construct($message, $code, $previous);
    }

    // custom string representation of object
    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

    public function customFunction() {
        echo "A custom function for this type of exception\n";
    }

}