<?php
/**
 *
 * User: MVB
 * Date: 25-06-2015
 * Time: 16:12
 */

namespace App\CN\CNAccessTokens;


use App\CN\Repositories\BaseRepository;
use App\CN\Repositories\CustomModel;
use App\CN\Transformers\UserTransformer;
use App\Exceptions\ErrorCodes;
use App\Exceptions\ResponseConstructor;
use Mockery\Exception;
use Tymon\JWTAuth\JWTAuth;
use Unirest;

class AccessTokenRepository extends BaseRepository
{
    /**
     *Method to retrieve cn user
     * @param JWTAuth $auth
     * @internal param $id
     */
    protected  $responseConstructor;//,$request;

    //protected $salt = "c2150$#@Mani";

    /**
     * @param JWTAuth $auth
     * @param UserTransformer $userTransformer
     * @param ErrorCodes $codes
     */
    public function __construct(JWTAuth $auth,ResponseConstructor $responseConstructor)
    {


        $this->responseConstructor = $responseConstructor;
        // $this->request=$request;
        $this->auth = $auth;
    }

    /**
     * Method for registering device for push notifications
     * @param $token
     * @param $device
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function registerUserDevicePush($token,$device){

        try {
            $ttoken = $this->retrieveTokenFromHeader($token);

            $id = $this->getUserIdFromToken($ttoken);

            $accessToken = AccessToken::where('userId',$id)->update(['pushRegistrationId' => $device['pushRegistrationId']]);;

            return $this->responseConstructor
                ->setResultCode(200)
                ->setResultTitle("Updated Device ID")
                ->successResponse("Updated");

        }catch (Exception $e){

            return $this->responseConstructor->respondNotFound("User already exists.");
        }

    }
}

