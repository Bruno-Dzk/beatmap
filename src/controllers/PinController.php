<?php

require_once "AppController.php";
require_once "src/domain/Pin.php";
require_once "src/repository/PinRepository.php";

class PinController extends AppController{

    public static function get_pin($param){
        //$pin = new Pin();
        //$json = json_encode($pin);
        echo $param;
    }

    public static function create_pin(){
        $data = AppController::getRequestJson();
        $pin = new Pin($data->track_id, $data->coords, $data->author_id, $data->no_likes, $data->no_dislikes, $data->verified);
        echo json_encode($pin);
    }
}