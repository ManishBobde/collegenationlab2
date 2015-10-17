<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 20-08-2015
 * Time: 22:58
 */

namespace App\CN\Transformers;


class UserDetailsTransformer extends Transformer{

    /**
     * @param $user
     * @return array
     */
    public function transform($users){
        return [
            "userId"=> $users['userId'],
           /* "firstName"=> $users->firstName,
            "lastName"=> $users->lastName,
            "email"=> $users->email,
            "avatarUrl"=> $users->avatarUrl,
            "dob"=> $users->dob,
            "collegeDeptId"=> $users->collegeDeptId,
            "deptStreamName"=> $users->deptStreamName,
            "courseYear"=> $users->courseYear,
            "roleType"=> $users->roleType*/
        ];

    }
}