<?php

namespace CN\Users;


interface UserInterface {

    public function getUserDetails($id);

    public function createUser();

    public function getAll();

}