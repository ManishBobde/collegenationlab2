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

    protected $codes,$eventTrans,$paginatorHelper;

    /**
     * @param EventTransformer $eventTrans
     * @param ErrorCodes $codes
     * @param PaginatorHelper $paginatorHelper
     */
    public function __construct(EventTransformer $eventTrans ,ResponseConstructor $codes,PaginatorHelper $paginatorHelper){

        $this->eventTrans=$eventTrans;
        $this->codes  = $codes;
        $this->paginatorHelper= $paginatorHelper;

    }

    /*
     * Method fetches the events with short description
     * @return mixed
     */
    public function retrieveShortEventDesc()
    {
        $events = Events::all();

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
    public function createEvents()
    {
        $event = new Events();

        $event->eventTitle =Input::get('eventTitle');

        $event->eventDesc = Input::get('eventDesc');

        $event->startDate =Input::get('startDate');

        $event->endDate =Input::get('endDate');

        $event->startTime =Input::get('startTime');

        $event->endTime =Input::get('endTime');

        $event->userId =Input::get('userId');

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

            return response()->json($this->codes->respondInternalError());

        }

    }

}