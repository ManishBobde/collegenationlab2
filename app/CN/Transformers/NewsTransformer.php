<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 29-08-2015
 * Time: 23:30
 */

namespace App\CN\Transformers;


class NewsTransformer extends Transformer{

    /**
     * @param $user
     * @return array
     */
    public function transform($news){

        return [
            'newsTitle'=>$news['newsTitle'],
            'newsShortDescription'=>mb_strimwidth($news['newsDesc'],0,25,"...."),
            'newsImageUrl'=>$news['newsImageUrl'],
            'newsId'=>$news['newsId'],
            'createdDate'=>$news['created_at'],
            'modifiedDate'=>$news['updated_at']

        ];

    }
}