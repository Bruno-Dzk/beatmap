<?php

require_once "Repository.php";
require_once "src/models/Pin.php";

class PinRepository extends Repository{
    
    private function getCoords($coordinates_id){
        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.coordinates WHERE coordinates_id = :coordinates_id
        ');
        $statement->bindParam(':coordinates_id', $coordinates_id, PDO::PARAM_STR);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function addPin($pin){
        $coordsUUID = uniqid("coords");
        $statement = $this->database->connect()->prepare('
            INSERT INTO public.coordinates VALUES(?, ?, ?);
        ');
        $statement->execute([
            $coordsUUID,
            $pin->getCoords()[0],
            $pin->getCoords()[1]
        ]);

        $statement = $this->database->connect()->prepare('
            INSERT INTO public.pin VALUES(?, ?, ?, ?, ?, ?, ?);
        ');
        $statement->execute([
            $pin->getPinID(),
            $pin->getTrackID(),
            $coordsUUID,
            $pin->getAppUserID(),
            $pin->getNoLikes(),
            $pin->getNoDislikes(),
            $pin->getVerified()
        ]);
        //$pin = $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getPinsInExtent($extent){
        $statement = $this->database->connect()->prepare('
            SELECT * FROM get_pins_in_extent(?, ?, ?, ?);
        ');
        //$statement->bindParam();
        $statement->execute($extent);

        $pins = $statement->fetchAll(PDO::FETCH_ASSOC);

        $pinObjects = array();
        foreach($pins as $pin){
            $coords = $this->getCoords($pin['coordinates_id']);

            array_push($pinObjects, new Pin(
                $pin["pin_id"],
                $pin["track_id"],
                [$coords["x"], $coords["y"]],
                $pin["app_user_id"],
                $pin["no_likes"],
                $pin["no_dislikes"],
                $pin["verified"]
            ));
        }

        return $pinObjects;
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
        $coords = $this->getCoords($pin['coordinates_id']);

        return new Pin(
            $pin["pin_id"],
            $pin["track_id"],
            [$coords["x"], $coords["y"]],
            $pin["app_user_id"],
            $pin["no_likes"],
            $pin["no_dislikes"],
            $pin["verified"]
        );
    }
}