<?php

require_once "Repository.php";
require_once "src/models/Pin.php";

class PinRepository extends Repository{

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
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
            $pin->getUser()->getID(),
            $pin->getNoLikes(),
            $pin->getNoDislikes(),
            $pin->getVerified()
        ]);
    }

    public function getPinsInExtent($extent){
        $statement = $this->database->connect()->prepare('
            select * from public.coords_in_extent(?, ?, ?, ?) natural inner join pin left join app_user on(pin.app_user_id = app_user.app_user_id);
        ');
        $statement->execute($extent);

        $assocs = $statement->fetchAll(PDO::FETCH_ASSOC);

        $pinObjects = array();
        foreach($assocs as $assoc){
            array_push($pinObjects, new Pin(
                $assoc["pin_id"],
                $assoc["track_id"],
                [$assoc["x"], $assoc["y"]],
                $assoc["username"],
                $assoc["no_likes"],
                $assoc["no_dislikes"],
                $assoc["verified"]
            ));
        }

        return $pinObjects;
    }

    public function getPin($pin_id): ?Pin{
        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.pin WHERE pin_id = :pin_id
            NATURAL INNER JOIN public.coordinates, public.app_user;
        ');
        $statement->bindParam(':pin_id', $pin_id, PDO::PARAM_STR);
        $statement->execute();

        $assoc = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$assoc) {
            return null;
        }

        return new Pin(
            $assoc["pin_id"],
            $assoc["track_id"],
            [$assoc["x"], $assoc["y"]],
            $assoc["username"],
            $assoc["no_likes"],
            $assoc["no_dislikes"],
            $assoc["verified"]
        );
    }
}