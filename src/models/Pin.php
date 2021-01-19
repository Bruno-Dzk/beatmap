<?php

class Pin implements JsonSerializable{
    private $pin_id = "";
    private $track_id = "";
    private $coords = [0.0, 0.0];
    private $username = "";
    private $no_likes = 0;
    private $no_dislikes = 0;
    private $verified = false;

    public function __construct($pin_id, $track_id, $coords, $username, $no_likes, $no_dislikes, $verified){
        $this->pin_id = $pin_id;
        $this->track_id = $track_id;
        $this->coords = $coords;
        $this->username = $username;
        $this->no_likes = $no_likes;
        $this->no_dislikes = $no_dislikes;
        $this->verified = $verified;
    }

    public function getPinID(){
        return $this->pin_id;
    }

    public function getTrackID(){
        return $this->track_id;
    }
    
    public function getUsername(){
        return $this->username;
    }

    public function getCoords(){
        return $this->coords;
    }

    public function getNoLikes(){
        return $this->no_likes;
    }

    public function getNoDislikes(){
        return $this->no_dislikes;
    }

    public function getVerified(){
        return $this->verified;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
