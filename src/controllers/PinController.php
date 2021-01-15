<?php

require_once "AppController.php";
require_once "src/models/Pin.php";
require_once "src/repository/PinRepository.php";

class PinController extends AppController{

    private $pin_repository;
    private $track_controller;

    public function __construct()
    {
        $this->pin_repository = new PinRepository();
        $this->track_controller = new TrackController();
    }

    public function pins($pin_id){
        $pin = $this->pin_repository->getPin($pin_id);
        echo json_encode($pin);
    }

    public function pinsInExtent(){
        $extent = [
            $_GET['xmin'],
            $_GET['ymin'],
            $_GET['xmax'],
            $_GET['ymax']
        ];
        $pins = $this->pin_repository->getPinsInExtent($extent);
        echo json_encode($pins);
    }

    public function addPin(){
        $data = AppController::getRequestJson();
        if(!$this->track_controller->verifyTrack($data->track_id)){
            http_response_code(400);
            return;
        }
        $pin = new Pin(uniqid("pin"), $data->track_id, $data->coords, "test_user", 0, 0, true);
        $this->pin_repository->addPin($pin);
    }
}