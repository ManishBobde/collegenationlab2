<?php namespace App\Http\Controllers;

use App\CN\CNCollegeDepartments\CollegeDepartment;
use App\CN\CNUsers\UsersRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\DepartmentRegisterRequest;
use Illuminate\Http\Request;

class DepartmentController extends ApiController
{

	protected $user;

	/**
	 * @param MessageRepository $message
	 */
	public function __construct(UsersRepository $user){

		//$this->auth = $auth;
		$this->user = $user ;
		$this->middleware('jwt.auth');
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
		$hodEmailId = $departmentRegisterRequest->get('hodEmailId');

		$deptData = $departmentRegisterRequest->all();

		$dept = new CollegeDepartment();

		$dept->teacherStrength=$deptData['totalLecturers'];
		$dept->academicYears =$deptData['academicYears'];
		$dept->streamCapacity =$deptData['streamCapacity'];
		$dept->totalCapacity =$deptData['academicYears']*$deptData['streamCapacity'];
		$dept->deptRegistrationToken =$this->getGUID();
		$dept->collegeId=$deptData['collegeId'];
		$dept->deptId=$deptData['deptId'];

		$dept->save();

		return "Department created successfully";
		//$this->user->createUser();

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
