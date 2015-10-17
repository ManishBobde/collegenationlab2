<?php

namespace App\Http\Controllers;

use App\CN\CNColleges\College;
use App\CN\CNUsers\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ModuleController extends ApiController
{


    public function __construct(){

        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function retrieveAccessibleModulesList($collegeId)
    {
//        $college = College::findorFail($collegeId);

        //$roles =  $user->roles()->where('role_type', 1)->first();

       // $modules = $college->modules()->orderBy('moduleName')->get();
        if (Cache::has('college_users_cache'))
        {
            $modules =  Cache::get('college_modules_cache');

        }else {
            $modules = DB::table('subscriptions')
                ->join('colleges', 'subscriptions.collegeId', '=', 'colleges.collegeId')
                ->join('modules', 'subscriptions.moduleId', '=', 'modules.moduleId')
                ->select('modules.moduleName', 'modules.moduleId', 'modules.moduleType', 'modules.moduleState')
                ->where('subscriptions.collegeId', $collegeId)
                ->get();

            Cache::add('college_modules_cache', $modules, 60);

        }
        return response()->json(
            [
                'modules' => collect($modules),
                'totalItems'=>collect($modules)->count()
            ],
            200
        );
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
}
