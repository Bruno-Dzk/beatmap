<?php

class Login{
    const EXPIRATION_TIME = 5 * 60; //5 minutes
    const REFRESH_TIME = 5 * 60; //5 minutes

    private $id;
    private $key;
    private $user_id;
    private $expired;

    public function __construct($id, $key, $user_id, $expired=false)
    {
        $this->id = $id;
        $this->key = $key;
        $this->user_id = $user_id;
        $this->expired = $expired;
    }

    static public function generateNew($user_id, $expired=false)
    {
        return new Login(
            uniqid("login"),
            base64_encode(random_bytes(16)),
            $user_id,
            $expired
        );
    }    

    public function getID(){
        return $this->id;
    }

    public function getKey(){
        return $this->key;
    }

    public function getUserID(){
        return $this->user_id;
    }

    public function hasExpired(){
        return $this->expired;
    }
}