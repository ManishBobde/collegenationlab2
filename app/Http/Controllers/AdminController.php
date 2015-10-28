<?php

namespace App\Http\Controllers;

use App\CN\CNDepartments\Department;
use App\CN\CNDomains\Domains;
use App\CN\CNPermissions\Permission;
use App\CN\CNRoles\Role;
use App\CN\CNUsers\User;
use App\Exceptions\ResponseConstructor;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;
use App\CN\Transformers\PermissionTransformer;
use Psy\Exception\Exception;

class AdminController extends ApiController
{

    protected $perTrans;
    /**
     * @var ResponseConstructor
     */
    private $responseConstructor;

    public function __construct(PermissionTransformer $perTrans,ResponseConstructor $responseConstructor){

        $this->middleware('jwt.auth');
        $this->perTrans=$perTrans;
        $this->responseConstructor = $responseConstructor;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function retrieveRoleBasedFeatures($userId)
    {
        try {
            $user = User::findorFail($userId);


            // $permission = Permission::all(['permissionName']);

            $permissions = $user->permissions()->orderBy('permissionName')->get(['permissions.permissionName']);
            //dd($permissions->all());

            // $this->perTrans->transformCollection($permissions);
            //Change the response as given in the documentation
            //foreach($permissions as $permission){

            // echo $permission->permissionName;

            //dd($this->perTrans->transform($permissions));
            //}
            return response()->json(["permissions" => $this->perTrans->transform($permissions)], 200);/*Need to rework Viplao*/
        }catch(Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle("User does not exist")
                ->respondWithError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function retrieveDomains()
    {
        try {

            if (Cache::has('college_domains_cache')) {
                $domains = Cache::get('college_domains_cache');

            } else {
                $domains = Domains::all();

                Cache::add('college_domains_cache', $domains, 60);

            }
            return response()->json(
                [
                    'totalItems' => collect($domains)->count(),
                    'items' => collect($domains)
                ],
                200
            );
        }catch (Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle("Issue with domains")
                ->respondWithError($e->getMessage());
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function retrieveStreamsForDomain($domainId)
    {

        try {

            if (Cache::has('college_department_stream_cache')) {
                $deptStreams = Cache::get('college_department_stream_cache');

            } else {
                $deptStreams = Department::where('domainId',$domainId);

                Cache::add('college_department_stream_cache', $deptStreams, 60);

            }
            return response()->json(
                [
                    'totalItems' => collect($deptStreams)->count(),
                    'items' => collect($deptStreams)
                ],
                200
            );
        }catch (Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle("Issue with departments")
                ->respondWithError($e->getMessage());
        }


    }

    /**
     * Method for suspending the user within respective tenant
     * @param $userId
     */
    public function suspendUser($userId){

        try {
            $user = User::findOrFail($userId);

            $user->update(['active' => 0]);

            return $this->responseConstructor
                ->setResultCode(200)
                ->setResultTitle("User suspended")
                ->successResponse("User suspended");
        }catch (Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle("User does not exist")
                ->respondWithError("User does not exist");
        }

    }


    /**
     *
     * Method for resuming the user within respective tenant
     * @param $userId
     */
    public function resumeUser($userId){

        try {
            $user = User::findOrFail($userId);

            $user->update(['active' => 1]);

            return $this->responseConstructor
                ->setResultCode(200)
                ->setResultTitle("User resumed")
                ->successResponse("User resumed");
        }catch (Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle("User does not exist")
                ->respondWithError("User does not exist");
        }

    }

    /**
     *
     * Method for deleting the user within respective tenant
     * @param $userId
     */
    public function deleteUser($userId){

        try {
            $user = User::findOrFail($userId);

            $user->delete();

            return $this->responseConstructor
                ->setResultCode(200)
                ->setResultTitle("User deleted")
                ->successResponse("User deleted");
        }catch (Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle("User does not exist")
                ->respondWithError("User does not exist");
        }

    }


}
