<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 20-08-2015
 * Time: 22:55
 */

namespace App\CN\Transformers;


abstract class Transformer {


    /**
     * @param $users
     * @return array
     */
    public function  transformCollection(array $items){

        return array_map(array($this,'transform'),$items);
    }

    public function transformCollections(array $model1,array $model2){

    }

    public abstract function transform($item);
}