<?php

require_once "Repository.php";
require_once "src/models/Pin.php";

class PinRepository extends Repository{
    public function savePin($pin){
        
    }
    public function getPin($pin_id): ?Pin{
        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.pin WHERE pin_id = :pin_id
        ');
        $statement->bindParam(':pin_id', $pin_id, PDO::PARAM_STR);
        $statement->execute();

        $pin = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$pin) {
            return null;
        }

        return new Pin(
            $pin["pin_id"],
            $pin["track_id"],
            $pin["test_coords"],
            $pin["test_user_id"],
            $pin["no_likes"],
            $pin["no_dislikes"],
            $pin["verified"]
        );
    }
}