<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 01-08-2015
 * Time: 21:14
 */

namespace App\CN\CNNews;


use App\CN\CNHelpers\PaginatorHelper;
use App\CN\Transformers\NewsTransformer;
use App\Exceptions\ErrorCodes;
use App\Exceptions\ResponseConstructor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;

class NewsRepository {

    protected $paginatorHelper, $codes,$newTrans;

    /**
     * @param JWTAuth $auth
     * @param UserTransformer $userTransformer
     * @param ErrorCodes $codes
     */
    public function __construct(NewsTransformer $newsTrans ,PaginatorHelper $paginatorHelper ,ResponseConstructor $codes)
    {
        $this->newsTrans=$newsTrans;
        $this->paginatorHelper = $paginatorHelper;
        $this->codes = $codes;
    }
    /*
     * Method fetches the events
     * @return mixed
     */
    public function getNewsItemsWithShortDescription()
    {
        $news = News::all();/*Needs to rework*/

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
    public function createNews()
    {
        $news = new News();

        $news->newsTitle = Input::get('newsTitle');

        $news->newsDesc = Input::get('newsDesc');

        $news->creatorId = Input::get('creatorId');

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

            return response()->json(['error' => 'News could not be created'], HttpResponse::HTTP_CONFLICT);

        }
    }


}