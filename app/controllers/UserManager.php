<?php

namespace App\Controllers;

class UserManager
{
    private $class;

    public function __construct($userClass)
    {
        $this->class = $userClass;
    }

    public function createNewUser($queryArray)
    {
        $user = new $this->class;
        foreach ($queryArray as $key => $value) {
            $user->$key = $value;
        }
        $user->save();
        return $user;
    }

    public function updateUser(&$user, $queryArray)
    {
        foreach ($queryArray as $key => $value) {
            $user->$key = $value;
        }
        $user->save();
    }

    public function getUserById($id)
    {
        return $this->getUser(['id' => $id]);
    }

    public function getUserByEmail($email)
    {
        return $this->getUser(['email' => $email]);
    }

    public function getUser($queryArray)
    {
        return $this->class::where($queryArray)->first();
    }
}
