<?php

class User implements JsonSerializable{
    private $id = "";
    private $username = "";
    private $password = "";
    private $verified = false;

    public function __construct($id, $username, $password, $verified = false){
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->verified = $verified;
    }

    public function getID(){
        return $this->id;
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

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}