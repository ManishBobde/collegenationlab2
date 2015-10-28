<?php

namespace App\Http\Controllers;

use App\CN\CNNews\News;
use App\CN\CNNews\NewsRepository;
use App\Exceptions\ErrorCodes;
use App\Exceptions\ResponseConstructor;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Validator;

class NewsController extends ApiController
{

    protected $news,$responseConstructor,$request;

    /**
     * @param NewsRepository $news
     * @param ResponseConstructor $responseConstructor
     * @param Request $request
     * @internal param NewsRepository $message
     */
    public function __construct(NewsRepository $news,ResponseConstructor $responseConstructor,Request $request ){

        $this->responseConstructor = $responseConstructor;
        $this->news = $news ;
        $this->request=$request;
        $this->middleware('jwt.auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function retrieveNewsItem($newsId)
    {
        try{

            $response = [
                'news' => []
            ];
            $statusCode = 200;

            $news = News::findOrFail($newsId);

            $response = [
                'newsTitle' => $news->newsTitle,
                'newsDesc' => $news->newsDescription,
                'creatorId' => $news->creatorId,
                'newsImageUrl' => url('uploads/newsimages/'.$news->newsImageUrl),
                'createdDate'=>$news->created_at,
                'modifiedDate'=>$news->updated_at
            ];

            return response()->json($response, $statusCode);

        }catch (Exception $e){
            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle($e->getMessage())
                ->respondWithError($e->getMessage());        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function createNews(Request $request)
    {
        try {

            return $this->news->createNews($this->request->header('Authorization'));
        }catch(Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle($e->getMessage())
                ->respondWithError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function deleteNews()
    {
        try {
            $newsId = Input::get('newsIds');

            News::destroy([$newsId]);

            return $this->responseConstructor
                ->setResultCode(200)
                ->setResultTitle("News Deleted!")
                ->successResponse("News Deleted!");
        }catch (Exception $e){
            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle("Error occured while news deletion")
                ->respondWithError("Error occured while news deletion");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function editNews($newsId)
    {
        try {

            $news = News::findOrFail($newsId);

            if(is_null($news)){

                return $this->responseConstructor
                    ->setResultCode(404)
                    ->setResultTitle("News not found")
                    ->respondWithError("News not found");

            }

            return $this->update($news);
        }catch (Exception $e){
            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle($e->getMessage())
                ->respondWithError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update($news)
    {
        $input = Input::all();
        $validation = Validator::make($input, News::$rules);

        if($validation->passes()){
            $news->update($input);
            return $this->responseConstructor
                ->setResultCode(200)
                ->setResultTitle("Updated News!")
                ->successResponse("News Updated!");
        }else{
            throw new Exception("Validation error Or Update error");
        }
    }

    /**a
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getNewsItemsWithShortDescription(Request $request)
    {
        try {
            return $this->news->getNewsItemsWithShortDescription($this->request->header('Authorization'));
        }catch (Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle($e->getMessage())
                ->respondWithError($e->getMessage());
        }

    }
}
