<?php

require_once "AppController.php";
require_once "src/models/Pin.php";
require_once "src/repository/PinRepository.php";

class PinController extends AppController{

    private $pin_repository;

    public function __construct()
    {
        $this->pin_repository = new PinRepository();
    }

    public function getPin($pin_id){
        $this->pin_repository->getPin($pin_id);
    }

    public function createPin(){
        $data = AppController::getRequestJson();
        $pin = new Pin($data->trackID, $data->coords, $data->authorID, 0, 0, true);
        echo json_encode($pin);
    }
}