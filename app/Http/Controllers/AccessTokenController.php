<?php namespace App\Http\Controllers;

use App\CN\CNAccessTokens\AccessTokenRepository;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\PushDeviceRequest;
use Illuminate\Http\Request;

class AccessTokenController extends ApiController
{

	protected $accessTokenRepository;
	/**
	 * @var Request
	 */
	protected $request;

	public function __construct(AccessTokenRepository $accessTokenRepository,Request $request)
	{

		$this->accessTokenRepository = $accessTokenRepository;
		//$this->middleware('jwt.auth');
		$this->request = $request;
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
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Method for registering android device for push notifications
	 * @param PushDeviceRequest $pushDeviceRequest
	 */
	public function registerDeviceId(PushDeviceRequest $pushDeviceRequest){

		return $this->accessTokenRepository->registerUserDevicePush($this->request->header('Authorization'),$pushDeviceRequest->all());
	}
}