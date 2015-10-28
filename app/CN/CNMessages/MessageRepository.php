<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 28-07-2015
 * Time: 23:14
 */

namespace App\CN\CNMessages;


use App\CN\CNAccessTokens\AccessToken;
use App\CN\CNAttachments\Attachment;
use App\CN\CNHelpers\PaginatorHelper;
use App\CN\CNUtilities\CNStringConstants;
use App\CN\Paginator\MessagePaginator;
use App\CN\PushNotifications\PushNotification;
use App\Exceptions\ResponseConstructor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use App\CN\PushNotifications;

define("inbox","1");
define("sent","2");
define("draft","3");
define("trash","4");
define("outbox","5");

class MessageRepository implements MessageInterface {

    protected $paginator,$responseConstructor;
    /**
     * @var PushNotification
     */
    private $pushNotification;


    /**
     * @param PaginatorHelper $paginator
     * @param MessagePaginator $msgpage
     */
    public function __construct(PaginatorHelper $paginator,ResponseConstructor $responseConstructor, PushNotification $pushNotification){

        $this->paginator = $paginator;
        $this->responseConstructor = $responseConstructor;

        $this->pushNotification = $pushNotification;
    }

    /**
     * Method to retrieve inbox messages for user
     * @return mixed
     */
    public function retrieveInboxMessages($userId)
    {
        try{
            $inboxMessages = Message::where('bucketId', inbox)
                ->where('userId', $userId)
                ->get();

            $items = collect($inboxMessages);

            return $this->paginateResults($items);
        }catch (Exception $e){

            throw new Exception("Inbox Messages retrievel error");

        }

        /* $before=0;$after=0;

         foreach ($messages->toArray() as $key => $value) {

             if ($key === 'from') {

                 $before = $messages->toArray()[$key];

             }
             else if($key === 'to'){

                 $after = $messages->toArray()[$key];

             }

         }
             return $messages;*/

    }

    /**
     * Method for retrieving sent messages
     * @return mixed
     */
    public function retrieveSentMessages($userId)
    {
        try{
            $sentMessages =  Message::where('bucketId', sent)
                ->where('userId', $userId)
                ->get();

            $items = collect($sentMessages);

            return $this->paginateResults($items);
        }catch (Exception $e){

            throw new Exception("Sent Messages retrievel error");

        }
    }

    /**
     * Method for retrieving draft messages
     * @return mixed
     */
    public function retrieveDraftMessages($userId)
    {
        try{
            $draftMessages =  Message::where('bucketId', draft)
                ->where('userId', $userId)
                ->get();

            $items = collect($draftMessages);

            return $this->paginateResults($items);
        }catch (Exception $e){

            throw new Exception("Draft Messages retrievel error");

        }
    }

    /**
     * Method for retrieving trashed messages
     * @return mixed
     */
    public function retrieveTrashedMessages($userId)
    {
        try {
            $trashMessages = Message::onlyTrashed()
                ->where('bucketId', trash)
                ->where('userId', $userId)
                ->get();

            $items = collect($trashMessages);

            return $this->paginateResults($items);
        }catch(Exception $e){

            throw new Exception("Trashed Messages retrievel error");

        }
    }

    /**
     * Method for submitting messages
     * @return mixeds
     */
    public function submitMessages()
    {

        $message = new Message();

        $message->recipients =Input::get('recipients');

        $message->title =Input::get('title');

        $message->description = Input::get('description');

        $message->isRead =Input::get('isRead');

        $message->senderId =Input::get('senderId');

        $totalAttachments =Input::get('totalAttachments');

        $fileMetadatas = Input::get('fileMetaData');



        /*$user->fill(Input::all());*/
        try {
            foreach($message->recipients as $recipient) {
                // dd(implode(",",$message->recipients));

                $message = Message::firstOrCreate(['recipients' => implode(",",(array)$message->recipients), 'title' => $message->title,
                    'description' => $message->description, 'isRead' => $message->isRead, 'senderId' => $message->senderId
                    , 'userId' => $recipient,'bucketId' => inbox]);

                $registrationIds = AccessToken::where('userId', $recipient)->get(['pushRegistrationId']);
                $pushRegId = $registrationIds->pull('pushRegistrationId');
                if(!is_null($pushRegId))
                    $this->pushNotification->send_notification($pushRegId,array($message->messageTitle));
            }

            dd($fileMetadatas);
            foreach($fileMetadatas as $fileMetadata){

                Attachment::create(['fileName' => implode(",",(array)$message->recipients), 'fileSize' => $message->title,
                    'filetype' => $message->description, 'attachmentUrl' => $message->isRead, 'attachmentPreviewUrl' => $message->senderId
                    , 'messageId' => $recipient,'bucketId' => inbox]);

            }
            if(!is_null($fileMetadata)){

                $fileName =$fileMetadata[CNStringConstants::FILENAME];
                $fileType = $fileMetadata[CNStringConstants::FILETYPE];
                $fileSize = $fileMetadata[CNStringConstants::FILESIZE];
            }else{

                $fileName =null;
                $fileType=null;
                $fileSize = null;
            }
            Message::firstOrCreate(['recipients' => implode(",",(array)$message->recipients), 'title' => $message->title,
                'description' => $message->description, 'isRead' => $message->isRead, 'senderId' => $message->senderId
                , 'userId' => $recipient,'bucketId' => sent]);

        }catch (Exception $e){

            return $this->responseConstructor->respondInternalError("Message could not be composed");

        }

    }

    /**
     * Method for retrieving trash messages
     * @return mixed
     */
    public function trashMessages($userId)
    {

    }

    /**
     * Method for deleting messages
     * @return mixed
     */
    public function deleteMessages()
    {
        try {
            $messageIds = Input::get('messageIds');
            foreach($messageIds as $messageId){

                $message = Message::findOrFail($messageId);

                $message->delete();

            }

            return $this->responseConstructor
                ->setResultCode(200)
                ->setResultTitle("Messages sent to Trash!")
                ->successResponse("Messages sent to trash Deleted!");
        }catch (Exception $e){
            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle("Error occured while news deletion")
                ->respondWithError("Error occured while news deletion");
        }
    }

    /**
     *
     */
    public function restoreMessages(){
        try {
            $messageIds = Input::get('messageIds');
            foreach($messageIds as $messageId){

                $message = Message::findOrFail($messageId);

                $message->restore();

            }

            return $this->responseConstructor
                ->setResultCode(200)
                ->setResultTitle("Messages restored!")
                ->successResponse("Messages restored!");
        }catch (Exception $e){
            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle("Error occured while news deletion")
                ->respondWithError("Error occured while news deletion");
        }



    }
    /**
     * Returns UUID of 32 characters
     *
     * @return string
     */
    public function generateUUID()
    {
        $currentTime = (string)microtime(true);
        $randNumber = (string)rand(10000, 1000000);
        $shuffledString = str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789");
        return md5($currentTime . $randNumber . $shuffledString);
    }

    /**
     * @param $bucketName
     * @return mixed
     */
    public function retrieveShortMessages($bucketName,$userId){
        try{

            //$bucket = //Bucket::where('bucketName',strtolower($bucketName))->get(['bucketType']);

            //$bucketType =  array_column($bucket->toArray(),'bucketType');

            //$index = 0;
            switch (constant(strtolower($bucketName))) {
                case 1:
                    return $this->retrieveInboxMessages($userId);
                    break;
                case 2:
                    return $this->retrieveSentMessages($userId);
                    break;
                case 3:
                    return $this->retrieveDraftMessages($userId);
                    break;
                case 4:
                    return $this->retrieveTrashedMessages($userId);
                    break;
            }
        }catch (Exception $e){

            return $this->responseConstructor
                ->setResultCode(404)
                ->setResultTitle($e->getMessage())
                ->respondWithError($e->getMessage());
        }

    }

    /**
     * Generic method for returning paginated results
     * @param $items
     * @return mixed
     */
    private function paginateResults($items){

        $page = Input::get('page', 1);

        $perPage = 2;

        $lengthpage  = new LengthAwarePaginator($items->forPage($page, $perPage),$items->count(), $perPage, $page);
        //$this->msgPage->offsetSet('next',$messages);
        return $this->paginator->respondWithPagination($lengthpage);
    }

}