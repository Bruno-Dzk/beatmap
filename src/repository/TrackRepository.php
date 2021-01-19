<?php

require_once "src/models/Track.php";
require_once "spotify_config.php";

const SEARCH_URL = "https://api.spotify.com/v1/search?type=track&market=".MARKET."&limit=10&offset=0";
const AUTHORIZE_URL = "https://accounts.spotify.com/api/token";
const GET_URL = "https://api.spotify.com/v1/tracks";

class TrackRepository{

    private $token_type = "";
    private $token = "";

    static private function parseArtists($artists){
        $parsed = [];
        foreach($artists as $artist){
            $parsed[] = $artist->name;
        }
        return $parsed;
    }

    private function authorize(){
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, AUTHORIZE_URL);
        curl_setopt($handle, CURLOPT_POST, 1);

        $auth_string = base64_encode(CLIENT_ID.":".CLIENT_SECRET);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Authorization: Basic ".$auth_string));
        curl_setopt($handle, CURLOPT_POSTFIELDS, "grant_type=client_credentials");
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        $execResult = curl_exec($handle);
        $auth_obj = json_decode($execResult);
        $this->token = $auth_obj->access_token;
        $this->token_type = $auth_obj->token_type;
    }

    public function searchTracks($query){
        $this->authorize();
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, SEARCH_URL."&q=".$query);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Authorization: ".$this->token_type." ".$this->token));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        $execResult = curl_exec($handle);
        $tracks = json_decode($execResult)->tracks->items;

        $http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($http_code != 200){
            throw new ErrorException("Search error");
        }

        $trackObjects = [];
        foreach($tracks as $track){
            $trackObjects[] = new Track(
                $track->id,
                $track->name,
                TrackRepository::parseArtists($track->artists),
                $track->album->images[2]->url
            );
        }
        return $trackObjects;
    }

    public function getTrack($id){
        $this->authorize();
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, GET_URL."/".$id);
        curl_setopt($handle, CURLOPT_HTTPHEADER, array("Authorization: ".$this->token_type." ".$this->token));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);
        $execResult = curl_exec($handle);
        $track = json_decode($execResult);

        $http_code = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($http_code != 200){
            throw new ErrorException("Could not get track");
        }

        return new Track(
            $track->id,
            $track->name,
            TrackRepository::parseArtists($track->artists),
            $track->album->images[2]->url
        );
    }
}