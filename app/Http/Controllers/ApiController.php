<?php
/**
 * 
 * User: MVB
 * Date: 25-06-2015
 * Time: 23:24
 */

namespace App\Http\Controllers;

use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Response;

class ApiController extends Controller{


    protected $statusCode;

    /**
     * @return statuscode
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }


    /**Method to respond if resource not found
     * @param $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found!'){

        return $this->setStatusCode(IlluminateResponse::HTTP_NOT_FOUND)->respondWithError($message);
    }

    /**
     * @param $message
     * @return response
     */
    public function respondInternalError($message = 'Internal Error'){

        return $this->setStatusCode(IlluminateResponse::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message);
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

        return Response::json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     * @return response
     */
    public function respondWithError($message){

        return $this->respond([
            'error'=>[
                'errorMessage'=>$message,
                'errorCode'=>$this->getStatusCode(),
                'errorTitle'=>$this->getErrTitle()
            ]
        ]);
    }

    /**
     * @param Paginator $page
     * @param $data
     * @return mixed
     */
    public function respondWithPagination(Paginator $page ,$data){

        $data = array_merge($data , [
            'paginator' =>[

                'total_count'=>$page->getTotal(),
                'total_ages' => $page->getTotal()/$page->getPerPage(),
                'current_page' => $page->getCurrentPage(),
                'limit' => $page->getPerPage()

            ]
        ]);

        return $this->respond($data);

    }

}