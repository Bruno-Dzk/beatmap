<?php

class Pin implements JsonSerializable{
    private $track_id = 0;
    private $coords = [0.0, 0.0];
    private $author_id = 0;
    private $no_likes = 0;
    private $no_dislikes = 0;
    private $verified = false;

    public function __construct($track_id, $coords, $author_id, $no_likes, $no_dislikes, $verified){
        $this->track_id = $track_id;
        $this->coords = $coords;
        $this->author_id = $author_id;
        $this->no_likes = $no_likes;
        $this->no_dislikes = $no_dislikes;
        $this->verified = $verified;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
