<?php
/**
 * Created by PhpStorm.
 * User: MVB
 * Date: 25-06-2015
 * Time: 01:12
 */

namespace app\CN\EventListeners;


interface AuthenticateListener {

    /**
     * @param $event
     */
    public function onSignUp($event);

    /**
     * @param $event
     */
    public function onCancel($event);

    /**
     * @param $event
     */
    public function onUserLogin($event);

    /**
     * @param $event
     */
    public function onUserLogout($event);

}