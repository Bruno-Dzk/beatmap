<?php

class User{
    private $id = "";
    private $email = "";
    private $username = "";
    private $password = "";
    private $verified = false;

    public function __construct($id, $email, $username, $password, $verified = false){
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->verified = $verified;
    }

    public function getID(){
        return $this->id;
    }

    public function getEmail(){
        return $this->email;
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function isVerified(){
        return $this->verified;
    }
}