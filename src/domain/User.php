<?php

class User{
    private $nick = "";
    private $email = "";

    public function __construct($nick, $email){
        $this->$nick = $nick;
        $this->$email = $email;
    }
}