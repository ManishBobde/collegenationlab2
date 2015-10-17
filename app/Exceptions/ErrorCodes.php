<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 19-07-2015
 * Time: 21:45
 */

namespace App\Exceptions;


use Illuminate\Http\Response;

abstract class ErrorCodes {

    /*HTTP Status Code	Reason	Response Model
    400	Bad Request - Request does not have a valid format, all required parameters, etc.
    401	Unauthorized Access - No currently valid session available.
    404	Not Found - Resource not found
    500	System Error - Specific reason is included in the error message*/


    protected $resultCode,$resultTitle;

    /**
     * @return errorCode
     */
    public function getResultCode()
    {
        return $this->resultCode;
    }

    /**
     * @param mixed errorCode
     * @return $this
     */
    public function setResultCode($resultCode)
    {
        $this->resultCode = $resultCode;

        return $this;
    }

    /**
     * @param mixed errorTitle
     * @return $this
     */
    public function setResultTitle($resultTitle)
    {
        $this->resultTitle = $resultTitle;

        return $this;
    }

    /**
     * @return errorTitle
     */
    public function getResultTitle()
    {
        return $this->resultTitle;
    }



    /**Method to respond if resource not found
     * @param $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found!',$resultTitle){

        return $this->setResultCode(Response::HTTP_NOT_FOUND)->setResultTitle($resultTitle)
            ->respondWithError($message);
    }

    /**
     * @param $message
     * @return response
     */
    public function respondInternalError($message = 'Internal Error'){

        return $this->setResultCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
    }

    /**
     * Generic method for response
     * @param $data
     * @param array $headers
     * @return
     * @internal param $message
     */
    public function respond($data ,$headers=[])
    {

        return response()->json($data, $this->getResultCode(), $headers);
    }

    /**
     * @param $message
     * @return response
     */
    public function respondWithError($message){

        return $this->respond([

                'resultCode'=>$this->getResultCode(),
                'resultTitle'=>$this->getResultTitle(),
                'resultMessage'=>$message,

        ]);
    }




}