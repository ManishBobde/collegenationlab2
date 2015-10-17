<?php namespace App\Http\Controllers;

/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 15-07-2015
 * Time: 22:44
 */


use App\CN\CNMessages\Message;
use App\CN\CNMessages\MessageRepository;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class MessageController extends ApiController {


    protected $message;

    /**
     * @param MessageRepository $message
     */
    public function __construct(MessageRepository $message ){

        //$this->auth = $auth;
        $this->message = $message ;
        $this->middleware('jwt.auth');
    }


    /**a
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function retrieveShortMessages($bucketname,$userId)
    {
        return $this->message->retrieveShortMessages($bucketname,$userId);

    }

    /**a
     * Display a particular msg.
     *
     * @return Response
     */
    public function retrieveMessageItem($msgId)
    {
        return $this->message->retrieveMessageItem($msgId);

    }

    /**a
     * Display a particular msg.
     *
     * @return Response
     */
    public function submitMessages(Request $request)
    {
        return $this->message->submitMessages();

    }

    /**a
     * Display a particular msg.
     *
     * @return Response
     */
    public function deleteMessage($msgId)
    {
        return $this->message->deleteMessage($msgId);

    }

}

