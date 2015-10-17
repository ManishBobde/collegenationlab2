<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 13-08-2015
 * Time: 21:49
 */

namespace App\CN\Repositories;


use App\CN\CNCollegeDepartments\CollegeDepartment;
use App\CN\Interfaces\CustomModel;
use App\CN\CNUtilities\CNStringConstants;
use App\Exceptions\ResponseConstructor;
use App\Exceptions\UserException;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use App\CN\CNAccessTokens\AccessToken;
use Tymon\JWTAuth\JWTAuth;



abstract class BaseRepository {

    protected $errorCodes;
    /**
     * @var JWTAuth
     */
    protected $auth;

    public function __construct(JWTAuth $auth,ResponseConstructor $errorCodes){
        $this->errorCodes = $errorCodes;
        $this->auth = $auth;
    }

    /**
     * Method for creating genric record for registration in DB
     * @param CustomModel $model
     * @return mixed
     */
    protected function createGenericRecord(CustomModel $model){

        try{
            $model->email   = Input::get(CNStringConstants::EMAIL);

            $password       = Input::get(CNStringConstants::PASSWORD);

            if(Cache::has('users_password_cache_'.$model->email)) {
                if (Cache::get('users_password_cache_' . $model->email) != $password) {

                    throw new Exception("Invalid Credentials");

                }
            }else{

                throw new Exception("Please use password provided in mail");
            }

            Cache::forget('users_password_cache_'.$model->email);

            $model->firstName = Input::get(CNStringConstants::FIRSTNAME);

            $model->lastName = Input::get(CNStringConstants::LASTNAME);

            $model-> registrationToken = Input::get(CNStringConstants::REGISTRATIONTOKEN);

            $collegeDeptData = $this->getUserDepartmentData($model->registrationToken);

            $model->roleId = Input::get(CNStringConstants::ROLEID);

            if(!is_null($collegeDeptData)) {

                $model->deptId = $collegeDeptData->collegeDeptId;

                $model->collegeId = $collegeDeptData->collegeId;
            }else{

                throw new Exception("Invalid registration Token!");
            }

            if(!is_null($password))

                $model->password = bcrypt($password);//temporary password received in email

            // $model->countryCode = Input::get('countryCode');

            // $model->slug = $model->firstName."_".$model->lastName;

            //$model->mobileNumber = Input::get('mobileNumber');

            // $this->sendOtpToVerifyMobileNumber(Input::get('mobileNumber'));

            /* if ( Input::hasFile('avatar')) {

                 $file = Input::file('avatar');
                 $name = time().'-'.$file->getClientOriginalName();
                 $file = $file->move('uploads/', $name);
                 $model->avatarUrl = $name;
                 //dd( $model->avatarUrl);
             }*/

            /*$user->fill(Input::all());*/
               $model->save();

            //revent(new UserRegistered($model, $password));

        } catch (Exception $e) {

            throw new UserException($e->getMessage());//response()->json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);

        }

        $media = Input::get('media');

        $accessToken = $this->auth->fromUser($model);

        $idleTimeAuthTokenExpirationDuration = $this->auth->getPayload($accessToken)->get('exp');

        $id =  $this->getUserIdFromToken($accessToken);

        if(!is_null($media)){

            $deviceType =$media[CNStringConstants::DEVICETYPE];
            $mediaType = $media[CNStringConstants::MEDIATYPE];
            $osName = $media[CNStringConstants::OSNAME];
        }else{

            $deviceType =null;
            $mediaType=null;
            $osName = null;
        }

        $accessTokens = AccessToken::firstOrCreate(['accessToken' => $accessToken, 'deviceType' => $deviceType,
            'mediaType' =>$mediaType, 'osName' => $osName, 'userId' => $id
            , 'idleTimeAuthTokenExpirationDuration' => $idleTimeAuthTokenExpirationDuration]);

        return response()->json([
            'accessToken' => $accessToken,
            'isActive' => '1',
            'idleTimeAuthTokenExpirationDuration'=>$idleTimeAuthTokenExpirationDuration
        ] ,200);

    }

    /**
     * Method for getting user department data
     * @param $registrationToken
     * @return null
     */
    private function getUserDepartmentData($registrationToken)
    {
        $deptData = null;
            if (!is_null($registrationToken)) {

                $deptData = CollegeDepartment::where('deptRegistrationToken', $registrationToken)->first(['collegeDeptId', 'collegeId']);
            }


        return $deptData;
    }



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