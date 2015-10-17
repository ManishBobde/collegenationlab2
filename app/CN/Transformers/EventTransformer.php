<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 29-08-2015
 * Time: 23:30
 */

namespace App\CN\Transformers;


class EventTransformer extends Transformer{

    /**
     * @param $user
     * @return array
     */
    public function transform($event){

        return [
            'eventId'=>$event['eventId'],
            'eventTitle'=>$event['eventTitle'],
            'eventDesc'=>mb_strimwidth($event['eventDesc'],0,25,"...."),
            'startDate'=>$event['startDate'],
            'endDate'=>$event['endDate'],
            'startTime'=>$event['startTime'],
            'endTime'=>$event['endTime'],
            'eventImageUrl'=>$event['eventImageUrl'],
            'createdDate'=>$event['created_at'],
            'modifiedDate'=>$event['updated_at']
        ];

    }
}