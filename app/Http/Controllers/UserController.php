<?php namespace App\Http\Controllers;

use App\CN\CNColleges\College;
use App\CN\CNUsers\UsersRepository;
use App\Events\ForgotPassword;
use App\Exceptions\ResponseConstructor;
use App\Http\Requests\EmailRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use App\CN\CNUsers\User;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use LogicException;
use Mockery\Exception;
use Tymon\JWTAuth\JWTAuth;
use Unirest;


class UserController extends ApiController {



	protected $cnuser,$request;
	/**
	 * @var ResponseConstructor
	 */
	private $responseConstructor;
	/**
	 * @var JWTAuth
	 */
	private $auth;

	/**
	 * @param UsersRepository|CNUserInterface|CNUsersRepository $cnuser
	 * @param Request $request
	 * @param ResponseConstructor $responseConstructor
	 * @internal param Guard $auth
	 */
	public function __construct(UsersRepository $cnuser,Request $request,ResponseConstructor $responseConstructor){

		$this->request=$request;
		$this->cnuser = $cnuser ;
		$this->responseConstructor = $responseConstructor;
		$this->middleware('jwt.auth', ['except' => array('registerUser', 'loginUser','sendPasswordOnUserEmail')]);	}

	/**
	 * Show the application registration form.
	 * for web app
	 * @return Response
	 */
	public function getRegister()
	{
		return view('auth.register');
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param RegisterRequest $registerRequest
	 * @return Response
	 * @internal param RegisterRequest $request
	 */
	public function registerUser(RegisterRequest $registerRequest)
	{

		return $this->cnuser->createUser();

	}

	/**
	 * Method for verifying OTP received from user
	 * @param Request $request
	 * @return mixed
	 */
	public function verifyOtp(Request $request)
	{

		return $this->cnuser->verifyOtpFromMobile($request->get('code'),$request->get('mobileNumber'));

	}

	/**
	 * Show the application login form.
	 * for Web App
	 * @return Response
	 */
	public function getLogin()
	{
		return view('auth.login');
	}

	/**
	 * Handle a login request to the application.
	 *
	 * @param LoginRequest $loginRequest
	 * @return Response
	 * @internal param LoginRequest $request
	 */
	public function loginUser(LoginRequest $loginRequest)
	{
		$credentials = $this->getCredentials($loginRequest);

		return $this->cnuser->authenticateUser($credentials);

	}

	/**
	 * Get the needed authorization credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	protected function getCredentials(Request $request)
	{
		return $request->all();
	}

	/**
	 * Log the user out of the application.
	 *
	 * @return Response
	 */
	public function logoutUser()
	{
		return $this->cnuser->logout($this->request->header('Authorization'));

		//return "logged Out!";
	}

	/**
	 * Method for getting other user profiles
	 * @param $slug
	 * @return mixed
	 */
	public function getOtherUserDetails($userId){

		return $this->cnuser->getOtherUserDetails($userId);
	}

	/**
	 *Method for getting user specific features
	 */
	public function getUserSpecificFeatures(){

		return $this->cnuser->getUserFeatures($this->request->header('Authorization'));
	}

	/**
	 * Method for retrieving the user profile
	 * @return mixed
	 */
	public function getUserProfile(){

		return $this->cnuser->getUserProfile($this->request->header('Authorization'));
	}

	/**
	 * Method for changing the password
	 * @param Request $request
	 */
	public function changePassword(Request $request,$userId){

		/*$ttoken = $this->cnuser->retrieveTokenFromHeader($this->request->header('Authorization'));

		$id = $this->cnuser->getUserIdFromToken($ttoken);*/

		$oldpassword = $request->get('oldPassword');

		$user = User::find($userId);
		if(!is_null($user)) {
			if (Hash::check($oldpassword, $user->password)) {

				$newpassword = $request->get('newPassword');

				$user->password = Hash::make($newpassword);

				$user->save();

				return $this->responseConstructor
					->setResultCode(200)
					->setResultTitle("Password changed")
					->successResponse("password changed");
			}else {

				return $this->responseConstructor
					->setResultCode(404)
					->setResultTitle("Old Password did not match")
					->respondWithError("Password did not match");
			}
		}else{

			return $this->responseConstructor
				->setResultCode(404)
				->setResultTitle("User does not exist")
				->respondWithError("User does not exist");
		}
	}


	/**
	 * Method for getting all users for the college tenant
	 * @param $collegeId
	 * @return mixed
	 */
	public function getAllUsersWithinTenantForCompose($collegeId){

		return $this->cnuser->getAllUsersWithinTenant($collegeId,$this->request->header('Authorization'));

	}

	/**
	 * Method for sending the mail if user forgets password
	 * @param $userId
	 * @return string
	 */
	public function forgotPassword($userId){

		$user = User::findOrFail($userId);

		\Event::fire(new ForgotPassword($user));

		return "Mail was sent successfully";

	}

	/**
	 * Method for sending password on mail for new users
	 * @param EmailRequest $request
	 * @return string
	 */
	public function sendPasswordOnUserEmail(EmailRequest $request){

		$email = $request->get('email');

		try {
			$count = User::where ('email',$email)->count();

			if ($count  >= 1)
				throw new Exception("User already exists");

			if(Cache::has('users_password_cache_'.$email))
				Cache::forget('users_password_cache_'.$email);


			$password = $this->generatePassword();

			Cache::add('users_password_cache_'.$email, $password, 60);

			Mail::queue('emails.email', ['email' => $email, 'password' => $password], function ($m) use ($email) {

				// $m->from("bobdemanish3@gmail.com");
				$m->to($email)->subject('Your credentials');

			});
		}catch (LogicException $e){

			return response()->json([

				"resultCode"=>500,
				"resultTitle"=> "Error",
				"resultMessage"=>"Error occured"

			],500);

		}catch (Exception $uve){


			return response()->json([

				"resultCode"=>500,
				"resultTitle"=> "Error",
				"resultMessage"=>"Email already registered"

			],500);

		}

		return response()->json([

			"resultCode"=>200,
			"resultTitle"=>  "Success",
			"resultMessage"=>"Mail Sent"

		],200);


	}

	/**
	 *Method for generating six word random password
	 * @param length
	 */
	private function generatePassword($l = 6)
	{

		return substr(md5(uniqid(mt_rand(), true)), 0, $l);

	}

	/**
	 * Method for sending OTP to users mobile number
	 * @param $mobileNo
	 */
	public function sendOtpToVerifyMobileNumber($mobileNo)
	{
		try {
			Unirest\Request::verifyPeer(false);
			$response = Unirest\Request::get("https://webaroo-mobile-verification.p.mashape.com/mobileVerification?phone=$mobileNo",
				array(
					"X-Mashape-Key" => "C87Hhc3Q8omshFfTyCiSb1F3yJmCp1Km8Gvjsn1pzv8E4jRL4b",
					"Accept" => "application/json"
				)
			);
			dd($response);
		}catch(Exception $e){

			throw new UserException($e->getMessage());
		}

	}

	/**
	 * Method for getting the users depending on usertype and collegedeptid
	 */
	public function getUsersWithinTenant(){

		$userTypes = Input::get('userTypes');

		$collegeId = Input::get('collegeId');

		$collegeDeptId = Input::get('departmentId');

		if (Cache::has('college_users_managed_cache'))
		{
			$users =  Cache::get('college_users_managed_cache');

		}else {

			$college = College::findorFail($collegeId);

			$users = DB::table('users')
				->join('colleges', 'users.collegeId', '=', 'colleges.collegeId')
				->join('collegedepartments', 'collegedepartments.collegeId', '=', 'colleges.collegeId')
				->join('permission_user','permission_user.userId', '=', 'users.userId')
				->join('permissions', 'permissions.permissionId', '=', 'permission_user.permissionId')
				->join('roles','users.roleId', '=', 'roles.roleId')
				->select('users.firstName', 'users.lastName', 'users.userId', 'users.roleId', 'users.avatarUrl'
					,'permissions.permissionName','permission_user.isEnabled')
				->whereIn('users.roleId', array($userTypes))
				->where('colleges.collegeId', $collegeId)
				->where('collegedepartments.collegeDeptId', $collegeDeptId)
				->distinct()
				->get();
			dd($users);

			$users = $college->users()->get(['users.firstName', 'users.lastName', 'users.userId', 'users.roleId', 'users.avatarUrl']);

			Cache::add('college_users_managed_cache', $users, 60);
		}
		return response()->json([
			'totalItems'=>$users->count(),
			'items' => $users,
		],
			200
		);
	}




}
