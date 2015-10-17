<?php namespace App\Bindings;
/**
 * Created by PhpStorm.
 * User: Hash
 * Date: 19-07-2015
 * Time: 12:50
 */

/**
 * Here we bind the interfaces with the implementations
 */
App::bind('CN\Users\UserInterface', 'App\CN\CNUsers\UsersRepository');

App::bind('App\CN\CNMessages\MessageInterface', 'App\CN\CNMessages\MessageRepository');

