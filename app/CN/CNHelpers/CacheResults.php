<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 21-08-2015
 * Time: 00:40
 */

namespace app\CN\CNHelpers;


class CacheResults {


    public function getByPage($page = 1, $limit = 10)
    {
        $key = md5('page'.$page.'.'.$limit);

        if($this->cache->has($key))
        {
            return $this->cache->get($key);
        }

        $pagination = $this->user->getByPage($page, $limit);

        $this->cache->put($key, $pagination);

        return $pagination;
    }

}