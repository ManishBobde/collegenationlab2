<?php

namespace App\Http\Controllers;

use App\CN\CNEvents\Events;
use App\CN\CNEvents\EventsRepository;
use App\Exceptions\ErrorCodes;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;

class EventsController extends ApiController
{

    protected $events,$responseConstructor;

    /**
     * @param EventsRepository $events
     * @param ResponseConstructor $responseConstructor
     * @param Request $request
     */
    public function __construct(EventsRepository $events,ResponseConstructor $responseConstructor,Request $request ){

        $this->responseConstructor = $responseConstructor;
        $this->events = $events ;
        $this->request=$request;
        $this->middleware('jwt.auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function retrieveEventItem($eventId)
    {
        try{

            $response = [
                'events' => []
            ];
            $statusCode = 200;

            $event = Events::findOrFail($eventId);

            $response = [
                'eventTitle' => $event->eventTitle,
                'eventDescription' => $event->eventDescription,
                'startDate' => $event->startDate,
                'endDate' => $event->endDate,
                'startTime' => $event->startTime,
                'endTime' => $event->endTime,
                'creatorId' => $event->creatorId,
                'eventImageUrl' => url('uploads/eventimages/'.$event->eventImageUrl)
            ];

            return response()->json($response, $statusCode);

        }catch (Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle($e->getMessage())
                ->respondWithError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function createEvent(Request $request)
    {
        try {
            return $this->events->createEvents($this->request->header('Authorization'));

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
    public function deleteEvent()
    {
        try {
            $eventId = Input::get('eventsIds');

            Events::destroy([$eventId]);

            return $this->responseConstructor
                ->setResultCode(200)
                ->setResultTitle("Deleted!")
                ->successResponse("Events Deleted!");
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
    public function editEvent($eventId)
    {
        try {

            $event = Events::findOrFail($eventId);

            if(is_null($event)){

                return $this->responseConstructor
                    ->setResultCode(404)
                    ->setResultTitle("Events not found")
                    ->respondWithError("Events not found");            }

            return $this->update($eventId);

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
    public function update($event)
    {
        $input = Input::all();
        $validation = Validator::make($input, Events::$rules);

        if($validation->passes()){

            $event->update($input);

            return $this->responseConstructor
                ->setResultCode(200)
                ->setResultTitle("Updated Events!")
                ->successResponse("Event Updated!");

        }else{
            throw new Exception("Validation error Or Update error");
        }
    }


    /**a
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getEventsWithShortDescription(Request $request)
    {
        try {
            return $this->events->getEventsWithShortDescription($this->request->header('Authorization'));
        }catch (Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle($e->getMessage())
                ->respondWithError($e->getMessage());
        }

    }

}
