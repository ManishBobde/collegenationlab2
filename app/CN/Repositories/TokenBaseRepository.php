<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 18-10-2015
 * Time: 10:59
 */

namespace App\CN\Repositories;


use App\Exceptions\ResponseConstructor;
use Tymon\JWTAuth\JWTAuth;

abstract class TokenBaseRepository {

    protected $auth;

    public function __construct(JWTAuth $auth,ResponseConstructor $errorCodes){
        $this->errorCodes = $errorCodes;
        $this->auth = $auth;
    }

    /**
     * Method to retrieve userId from Token
     * @param $ttoken
     * @return mixed
     */
    public function getUserIdFromToken($ttoken)
    {
        $id = $this->auth->getPayload($ttoken)->get('sub');

        return $id;

    }

    /**
     * Method to retrieve token header from the access token
     * @param $token
     * @return mixed
     */
    public function retrieveTokenFromHeader($token)
    {

        $index = 1;

        $ttoken = explode(" ", $token);

        return $ttoken[$index];

    }

}