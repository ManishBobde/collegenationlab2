<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 01-08-2015
 * Time: 21:14
 */

namespace App\CN\CNEvents;



use App\CN\CNHelpers\PaginatorHelper;
use App\CN\Transformers\EventTransformer;
use App\Exceptions\ErrorCodes;
use App\Exceptions\ResponseConstructor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Input;

class EventsRepository {

    protected $responseConstructor,$eventTrans,$paginatorHelper;

    /**
     * @param EventTransformer $eventTrans
     * @param ErrorCodes $codes
     * @param PaginatorHelper $paginatorHelper
     */
    public function __construct(EventTransformer $eventTrans ,ResponseConstructor $responseConstructor,PaginatorHelper $paginatorHelper){

        $this->eventTrans=$eventTrans;
        $this->responseConstructor  = $responseConstructor;
        $this->paginatorHelper= $paginatorHelper;

    }

    /*
     * Method fetches the events with short description
     * @return mixed
     */
    public function getEventsWithShortDescription($ttoken)
    {
        $id = $this->getUserIdFromToken($ttoken);

        $collegeData = User::where('userId',$id)->get(['collegeId']);

        $collegeId = $collegeData->pull('collegeId');

        $events = Events::where('collegeId',$collegeId);

        $data= $this->eventTrans->transformCollection($events->toArray());

        $items = collect($data);

        $page = Input::get('page', 1);

        $perPage = 2;

        $page  = new LengthAwarePaginator($items->forPage($page, $perPage),$items->count(), $perPage, $page);

        return $this->paginatorHelper->respondWithPagination($page);


    }


    /**
     * Method for creation of events
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createEvents($token)
    {
        $event = new Events();

        $event->eventTitle =Input::get('eventTitle');

        $event->eventDescription = Input::get('eventDescription');

        $event->startDate =Input::get('startDate');

        $event->endDate =Input::get('endDate');

        $event->startTime =Input::get('startTime');

        $event->endTime =Input::get('endTime');

        $ttoken = $this->retrieveTokenFromHeader($token);

        $id = $this->getUserIdFromToken($ttoken);

        $collegeData = User::where('userId',$id)->get(['collegeId']);

        $collegeId = $collegeData->pull('collegeId');

        $event->creatorId = $id ;

        $event->collegeId = $collegeId;

        if ( Input::hasFile('eventImageUrl')) {

            $file = Input::file('eventImageUrl');
            $name = time().'-'.$file->getClientOriginalName();
            $file = $file->move('uploads/eventimages', $name);
            $event->eventImageUrl = $name;
            //dd( $model->avatarUrl);
        }

        /*$user->fill(Input::all());*/
        try {

            $eventId = $event->save();

            return response()->json(['eventId'=>$event->eventId],200);

        }catch (Exception $e){

            return $this->responseConstructor->respondInternalError("Events could not be created");

        }

    }

}