<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 01-08-2015
 * Time: 21:14
 */

namespace App\CN\CNNews;


use App\CN\CNHelpers\PaginatorHelper;
use App\CN\CNUsers\User;
use App\CN\Repositories\TokenBaseRepository;
use App\CN\Transformers\NewsTransformer;
use App\Exceptions\ErrorCodes;
use App\Exceptions\ResponseConstructor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class NewsRepository extends TokenBaseRepository{

    protected $paginatorHelper, $responseConstructor,$newTrans;

    /**
     * @param JWTAuth $auth
     * @param UserTransformer $userTransformer
     * @param ErrorCodes $codes
     */
    public function __construct(NewsTransformer $newsTrans ,PaginatorHelper $paginatorHelper ,ResponseConstructor $responseConstructor)
    {
        $this->newsTrans=$newsTrans;
        $this->paginatorHelper = $paginatorHelper;
        $this->responseConstructor = $responseConstructor;
    }
    /*
     * Method fetches the events
     * @return mixed
     */
    public function getNewsItemsWithShortDescription($ttoken)
    {
        $id = $this->getUserIdFromToken($ttoken);

        $collegeData = User::where('userId',$id)->get(['collegeId']);

        $collegeId = $collegeData->pull('collegeId');

        $news = News::where('collegeId',$collegeId);

        $data= $this->newsTrans->transformCollection($news->toArray());

        $items = collect($data);

        $page = Input::get('page', 1);

        $perPage = 2;

        $lengthpage  = new LengthAwarePaginator($items->forPage($page, $perPage),$items->count(), $perPage, $page);

        return $this->paginatorHelper->respondWithPagination($lengthpage);
    }

    /*
     * Method to create event
     *
     */
    public function createNews($token)
    {
        $news = new News();

        $news->newsTitle = Input::get('newsTitle');

        $news->newsDescription = Input::get('newsDescription');

        $ttoken = $this->retrieveTokenFromHeader($token);

        $id = $this->getUserIdFromToken($ttoken);

        $collegeData = User::where('userId',$id)->get(['collegeId']);

        $collegeId = $collegeData->pull('collegeId');

        $news->creatorId = $id ;

        $news->collegeId = $collegeId;

        if ( Input::hasFile('newsImageUrl')) {

            $file = Input::file('newsImageUrl');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('uploads/newsimages', $name);
            $news->newsImageUrl = $name;
            //dd( $model->avatarUrl);
        }

        /*$user->fill(Input::all());*/
        try {

            $news->save();

            return response()->json(['newsId'=>$news->newsId],200);

        } catch (Exception $e) {

            return $this->responseConstructor->respondInternalError("News could not be created");

        }
    }


}