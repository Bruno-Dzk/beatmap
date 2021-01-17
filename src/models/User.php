<?php

class User{
    private $id = "";
    private $username = "";
    private $email = "";
    private $password = "";

    public function __construct($id, $username, $email, $password){
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function getID(){
        return $this->id;
    }

    public function getUsername(){
        return $this->username;
    }
    
    public function getEmail(){
        return $this->email;
    }

    public function getPassword(){
        return $this->password;
    }
}