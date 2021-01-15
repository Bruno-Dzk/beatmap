<?php

require_once "AppController.php";
require_once "src/models/Track.php";
require_once "src/repository/TrackRepository.php";

class TrackController extends AppController{

    private $trackRepository;

    public function __construct()
    {
        $this->trackRepository = new TrackRepository();
    }

    public function searchTracks(){
        if(!isset($_GET['query'])){
            die("Missing GET parameter: query");
        }
        $query = urlencode($_GET['query']);
        try{
            $tracks = $this->trackRepository->searchTracks($query);
            echo json_encode($tracks);
        }catch(ErrorException $e){
            http_response_code(404);
        }
    }

    public function verifyTrack($track_id){
        try{
            $this->trackRepository->getTrack($track_id);
            return true;
        }catch(ErrorException $e){
            return false;
        }
    }

    public function track($track_id){
        $track = $this->trackRepository->getTrack($track_id);
        echo json_encode($track);
    }

    public function test(){
        var_dump($this->verifyTrack("3xKsf9qdS1CyvXSMEid6g8"));
    }
}