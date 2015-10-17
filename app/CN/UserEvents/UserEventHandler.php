<?php
/**
 * Created by PhpStorm.
 * User: MVB
 * Date: 28-03-2015
 * Time: 16:02
 */

namespace app\CN\EventListeners;


use app\CN\EventListeners\AuthenticateListener;

class UserEventHandler implements AuthenticateListener{


    /**
     * @param $event
     */
    public function onSignUp($event){


    }

    /**
     * @param $event
     */
    public function onCancel($event){

    }

    /**
     * @param $event
     */
    public function onUserLogin($event){

    }

    /**
     * @param $event
     */
    public function onUserLogout($event){

    }

    /**
     * @param $events
     */
    public function subscribe($events){

        $events->listen('user.signup','UserEventHandler@onSignUp');
        $events->listen('user.cancel','UserEventHandler@onCancel');
        $events->listen('user.login','UserEventHandler@onUserLogin');
        $events->listen('user.logout','UserEventHandler@onUserLogout');

    }

}