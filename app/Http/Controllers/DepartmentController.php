<?php namespace App\Http\Controllers;

use App\CN\CNCollegeDepartments\CollegeDepartment;
use App\CN\CNRoles\RoleEnum;
use App\CN\CNUsers\User;
use App\CN\CNUsers\UsersRepository;
use App\Exceptions\ResponseConstructor;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\DepartmentRegisterRequest;
use Illuminate\Http\Request;

class DepartmentController extends ApiController
{

	protected $user;
	/**
	 * @var ResponseConstructor
	 */
	private $responseConstructor;

	/**
	 * @param MessageRepository $message
	 */
	public function __construct(UsersRepository $user,ResponseConstructor $responseConstructor){

		//$this->auth = $auth;
		$this->user = $user ;
		$this->middleware('jwt.auth');
		$this->responseConstructor = $responseConstructor;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @param Requests\DepartmentRegisterRequest $departmentRegisterRequest
	 * @return Response
	 */
	public function createDepartment(DepartmentRegisterRequest $departmentRegisterRequest)
	{
		try {

			$deptData = $departmentRegisterRequest->all();


			$dept = new CollegeDepartment();

			$dept->departmentDomain = $deptData['departmentDomain'];
			$dept->streamId = $deptData['streamId'];
			$dept->departmentName = $deptData['departmentName'];

			$dept->teacherStrength = $deptData['totalLecturers'];
			$dept->academicYears = $deptData['totalAcademicYears'];
			$dept->departmentSeatingCapacity = $deptData['departmentSeatingCapacity'];
			$dept->totalSeatingCapacity = $deptData['totalSeatingCapacity'];
			$dept->deptRegistrationToken = $this->getGUID();
			$dept->collegeId = $deptData['collegeId'];

			$dept->save();

			$user = new User();
			$user->email = $deptData['hodEmailId'];
			$user->firstName = $deptData['hodFirstName'];
			$user->lastName = $deptData['hodLastName'];
			$user->roleId = RoleEnum::HOD;
			$user->deptId = $dept->collegeDeptId;
			$user->password = bcrypt($this->user->generatePassword());
			$user->registrationToken = $dept->deptRegistrationToken;
			$user->collegeId = $dept->collegeId;


			$user->save();

			return response()->json(["departmentId"=>$dept->deptRegistrationToken], 200);
			//$this->user->createUser();
		}catch (Exception $e){

			return $this->responseConstructor
				->setResultCode(404)
				->setResultTitle("Error occurred while creating department")
				->respondWithError("Department not created");
		}
	}

	private function getGUID(){

		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);// "-"
		$uuid = substr($charid, 0, 8).$hyphen
			.substr($charid, 8, 4).$hyphen
			.substr($charid,12, 4).$hyphen
			.substr($charid,16, 4).$hyphen
			.substr($charid,20,12)
			;// "}"
		return $uuid;
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}



	/**a
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function retrieveEvents(Request $request)
	{
		return $this->events->retrieveEvents();

	}
}
