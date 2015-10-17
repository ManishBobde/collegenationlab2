<?php

namespace App\Http\Controllers;

use App\CN\CNPermissions\Permission;
use App\CN\CNRoles\Role;
use App\CN\CNUsers\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;
use App\CN\Transformers\PermissionTransformer;

class AdminController extends ApiController
{

    protected $perTrans;

    public function __construct(PermissionTransformer $perTrans){

        $this->middleware('jwt.auth');
        $this->perTrans=$perTrans;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function retrieveRoleBasedFeatures($userId)
    {
        $user = User::findorFail($userId);


       // $permission = Permission::all(['permissionName']);

        $permissions =  $user->permissions()->orderBy('permissionName')->get(['permissions.permissionName']);
       //dd($permissions->all());

       // $this->perTrans->transformCollection($permissions);
        //Change the response as given in the documentation
        //foreach($permissions as $permission){

           // echo $permission->permissionName;

            //dd($this->perTrans->transform($permissions));
        //}
        return response()->json(["permissions"=>$this->perTrans->transform($permissions)],200);/*Need to rework Viplao*/
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
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


}
