<?php
/**
 *
 * User: MVB
 * Date: 25-06-2015
 * Time: 16:12
 */

namespace App\CN\CNDepartments;


use App\CN\CNAccessTokens\AccessToken;
use App\CN\CNColleges\College;
use App\CN\CNDepartments\Department;
use App\CN\Repositories\BaseRepository;
use App\CN\Repositories\CustomModel;
use App\CN\Transformers\UserTransformer;
use App\Events\UserRegistered;
use App\Exceptions\ErrorCodes;
use App\Exceptions\ResponseConstructor;
use App\Http\Requests\Request;
use CN\Users\UserInterface;
use App\CN\CNUsers\User;
use Illuminate\Http\Response;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Mockery\Exception;
use Tymon\JWTAuth\JWTAuth;
use Unirest;

class DepartmentRepository
{
    /**
     *Method to retrieve cn user
     * @param JWTAuth $auth
     * @internal param $id
     */
    protected $auth, $mailer, $userTransformer, $responseConstructor;//,$request;

    //protected $salt = "c2150$#@Mani";

    /**
     * @param JWTAuth $auth
     * @param UserTransformer $userTransformer
     * @param ErrorCodes $codes
     */
    public function __construct(JWTAuth $auth, UserTransformer $userTransformer, ResponseConstructor $responseConstructor)
    {

        $this->auth = $auth;
        $this->userTransformer = $userTransformer;
        $this->responseConstructor = $responseConstructor;
        // $this->request=$request;
    }

}

