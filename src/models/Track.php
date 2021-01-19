<?php

class Track implements JsonSerializable{

    private $track_id = "";
    private $name = "";
    private $artists = [];
    private $imgURL = "";

    public function __construct($track_id, $name, $artists, $imgURL)
    {
        $this->track_id = $track_id;
        $this->name = $name;
        $this->artists = $artists;
        $this->imgURL = $imgURL;
    }

    public function getTrackID(){
        return $this->track_id;
    }

    public function getName(){
        return $this->name;
    }
    
    public function getArtists(){
        return $this->artists;
    }

    public function getImgURL(){
        return $this->imgURL;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}