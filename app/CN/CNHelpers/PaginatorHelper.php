<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 20-08-2015
 * Time: 23:45
 */

namespace App\CN\CNHelpers;


use Illuminate\Pagination\LengthAwarePaginator;

class PaginatorHelper {


    /**
     * @param Paginator $page
     * @param $data
     * @return mixed
     */
    public function respondWithPagination(LengthAwarePaginator $page){


        $data =  array(
            'items'=>$page->items(),
            'total_count'=>$page->total(),
            'total_pages' => $page->total()/$page->perPage(),
            'current_page' => $page->currentPage(),
            'limit' => $page->perPage()


            /*'cursor' =>[

                "prev"=> "1299061169043267:0:1",
                "hasNext"=> true,
                "next"=> "1299061158809627:0:0",
                "hasPrev"=> true,
                "total"=> null,
            ]*/);
        return $this->respond($data);

    }

    public function respond($data)
    {
        return response()->json($data);
    }

}