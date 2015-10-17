<?php
/**
 *
 * User: MVB
 * Date: 25-06-2015
 * Time: 16:12
 */

namespace App\CN\CNUsers;

define("FIRST_ROW","0");

use App\CN\CNAccessTokens\AccessToken;
use App\CN\CNColleges\College;
use App\CN\CNUtilities\CNStringConstants;
use App\CN\Repositories\BaseRepository;
use App\CN\Repositories\CustomModel;
use App\CN\Transformers\UserDetailsTransformer;
use App\CN\Transformers\UserTransformer;
use App\Exceptions\ErrorCodes;
use App\Exceptions\ResponseConstructor;
use App\Exceptions\UserException;
use CN\Users\UserInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Tymon\JWTAuth\JWTAuth;
use Unirest;

class UsersRepository extends BaseRepository implements UserInterface
{
    /**
     *Method to retrieve cn user
     * @param JWTAuth $auth
     * @internal param $id
     */

    //const FIRST_ROW = 0;

    protected $auth, $mailer, $userTransformer, $errorCodes,$userDetailsTransformer;//,$request;

    //protected $salt = "c2150$#@Mani";

    /**
     * @param JWTAuth $auth
     * @param UserTransformer $userTransformer
     * @param ErrorCodes $codes
     */
    public function __construct(JWTAuth $auth,UserDetailsTransformer $userDetailsTransformer,UserTransformer $userTransformer, ResponseConstructor $errorCodes)
    {
        $this->auth = $auth;
        $this->userTransformer = $userTransformer;
        $this->errorCodes = $errorCodes;
        $this->userDetailsTransformer=$userDetailsTransformer;
    }

    /**
     * Method for getting user details
     * @param $id
     * @return mixed
     */
    public function getUserDetails($id)
    {

        return User::findorFail($id);
    }


    /**
     * Method for getting user details
     * @param $token
     * @param $slug
     * @return mixed
     */
    public function getOtherUserDetails($userId)
    {
        //$ttoken = $this->retrieveTokenFromHeader($token);

        //$id = $this->getUserIdFromToken($ttoken);

        $users = DB::table('users')
            ->join('departments', 'users.deptId', '=', 'departments.deptId')
            ->join('collegedepartments', 'collegedepartments.collegeDeptId', '=', 'departments.deptId')
            ->join('roles','users.roleId', '=', 'roles.roleId')
            ->select('users.userId','users.firstName','users.lastName','users.email','users.avatarUrl','users.dob','collegedepartments.collegeDeptId'
                , 'departments.deptStreamName','users.academicYear','roles.roleType','collegedepartments.collegeId')
            ->where('users.userId',$userId)
            ->get();

        if ( empty($users)) {
            return $this->errorCodes->respondNotFound("Not Found", "Title");
        }
        // $userDetailsResp = $this->userDetailsTransformer->transformCollection($users[0]);

        return response()->json($users[FIRST_ROW], 200);



    }


    /**
     * Register new user be it student or lecturer
     */
    public function createUser()
    {
        try {
            return parent::createGenericRecord(new User());
        }catch (UserException $e){
             return $this->errorCodes->setResultCode(404)
                 ->setResultTitle("Invalid Credentials")
                 ->respondWithError($e->getMessage());
        }
    }

    /**
     * Method for sending OTP to mobile number
     * @param $code
     * @param $mobileNo
     */
    public function verifyOtpFromMobile($code, $mobileNo)
    {

        $response = Unirest\Request::get("https://webaroo-mobile-verification.p.mashape.com/mobileVerification?code=$code&phone=$mobileNo",
            array(
                "X-Mashape-Key" => "C87Hhc3Q8omshFfTyCiSb1F3yJmCp1Km8Gvjsn1pzv8E4jRL4b",
                "Accept" => "application/json"
            )
        );

    }

    /**
     * Method for getting user features
     * @param $token
     */
    public function getUserFeatures($token)
    {


    }

    /**
     * @param $credentials
     * @return \Symfony\Component\HttpFoundation\Response
     * @internal param $auth
     * @internal param $request
     */
    public function  authenticateUser(array $credentials)
    {
        $device =null;$mediaType=null;$os = null;
        try {
            if(!is_null($credentials)) {

                $email = $credentials[CNStringConstants::EMAIL];
                $password =$credentials[CNStringConstants::PASSWORD];
                $media = $credentials[CNStringConstants::MEDIA];
            }

            if(!is_null($media)){

                $deviceType =$media[CNStringConstants::DEVICETYPE];
                $mediaType = $media[CNStringConstants::MEDIATYPE];
                $osName = $media[CNStringConstants::OSNAME];
            }

            if(!empty($email) && !empty($password)) {
                if (Auth::attempt(['email' => $email, 'password' => $password
                    , 'isActive' => '1'])
                ) {

                    $onlyCredentials = array('email' => $email, 'password' =>$password);

                    // verify the credentials and create a token for the user
                    if (!$accessToken = $this->auth->attempt($onlyCredentials)) {
                        return $this->errorCodes->setResultCode(401)->respondWithError("Invalid Credentials");

                    }
                    // dd($this->auth->getPayload(true));

                    $idleTimeAuthTokenExpirationDuration = $this->auth->getPayload($accessToken)->get('exp');

                    $userId = $this->getUserIdFromToken($accessToken);


                    $accessTokens = AccessToken::firstOrCreate(['accessToken' => $accessToken, 'deviceType' => $deviceType,
                        'mediaType' => $mediaType, 'osName' => $osName, 'userId' => $userId
                        , 'idleTimeAuthTokenExpirationDuration' => $idleTimeAuthTokenExpirationDuration]);

                    return response()->json(['accesstoken' => $accessToken, 'isActive' => '1', 'idleTimeAuthTokenExpirationDuration' => $idleTimeAuthTokenExpirationDuration]);
                    //return response()->json(['name' => 'Abigail', 'state' => 'CA']);

                } else {
                    Log::info("User with email" . $credentials['email'] . "was not found");
                    return $this->errorCodes->setResultCode(404)
                        ->setResultTitle("User not exists")
                        ->respondWithError("User does not exist");

                }
            }
        } catch (JWTException $e) {
            // something went wrong
            return $this->errorCodes->respondInternalError("Something fishy happened");
        }

    }

    public function getAll()
    {
        return User::all();
    }

    /*public function findByUserNameOrCreate($userData)
    {
        if ($fromFB) {
            $users = $userData->user;
            return CNUsersModel::firstOrCreate([
                'first_name' => $users['first_name'],
                'last_name' => $users['last_name'],
                'email' => $users['email']
            ]);
        } else {

            $users = $userData->name;
            $emailarr =$userData->emails;
            $email =$emailarr->value;
            return SalonUsersModel::firstOrCreate([
                'first_name' => $users['familyName'],
                'last_name' => $users['givenName'],
                'email' => $email
            ]);
        }
    }*/

    /**
     *Generate access token
     * @return
     */
//    public function generateAccessToken(){
//
//        return bcrypt(str_random(60));
//
//    }

    /**
     * Method to logout user
     * @return bool
     */
    public function logout($token)
    {

        $ttoken = $this->retrieveTokenFromHeader($token);

        $id = $this->getUserIdFromToken($ttoken);

        $this->auth->invalidate($ttoken);

        $accessToken = AccessToken::where('accesstoken', $ttoken)->first();

        $accessToken->delete();

        return $this->errorCodes
            ->setResultCode(200)
            ->setResultTitle("Logged Out!")
            ->successResponse("User logged out!");
    }

    /**
     * Method to retrieve token header from the access token
     * @param $token
     * @return mixed
     */
    public function retrieveTokenFromHeader($token)
    {

        return parent::retrieveTokenFromHeader($token);

    }

    /**
     * Method to get user ID from access token
     * @param $ttoken
     * @return mixed
     */
    public function getUserIdFromToken($ttoken)
    {
        return parent::getUserIdFromToken($ttoken);

    }

    /**
     * Method to get all users with tenant
     * @param $collegeId
     * @param $token
     * @return mixed
     */
    public function getAllUsersWithinTenant($collegeId,$token)
    {
        if (Cache::has('college_users_cache'))
        {
            $users =  Cache::get('college_users_cache');

        }else {
           /* $ttoken = $this->retrieveTokenFromHeader($token);

            $id = $this->getUserIdFromToken($ttoken);*/

            $college = College::findorFail($collegeId);

            $users = $college->users()->get(['users.firstName', 'users.lastName', 'users.userId', 'users.roleId', 'users.avatarUrl']);

            Cache::add('college_users_cache', $users, 60);
        }
        return response()->json([
            'totalItems'=>$users->count(),
            'items' => $users,
        ],
            200
        );

    }



}