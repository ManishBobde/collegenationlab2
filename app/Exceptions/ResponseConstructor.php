<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 08-10-2015
 * Time: 22:16
 */

namespace App\Exceptions;


class ResponseConstructor extends ErrorCodes{

    /**
     * Method for sending the success response for any api
     */
    public function successResponse($message){

        return parent::respond([

                'resultCode'=>$this->getResultCode(),
                'resultTitle'=>$this->getResultTitle(),
                'resultMessage'=>$message,

        ]);
    }
}