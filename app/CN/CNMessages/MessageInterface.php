<?php
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 28-07-2015
 * Time: 23:02
 */

namespace App\CN\CNMessages;


interface MessageInterface {

    public function retrieveInboxMessages($userId);

    public function retrieveSentMessages($userId);

    public function retrieveDraftMessages($userId);

    public function retrieveTrashedMessages($userId);

    public function submitMessages();

    public function trashMessages($userId);

    public function deleteMessages();

}