<?php

require_once "Repository.php";
require_once "src/models/Login.php";

class LoginRepository extends Repository{
    

    public function addLogin($login){

        $statement = $this->database->connect()->prepare('
            INSERT INTO public.logins VALUES(?, ?, ?, ?, ?);
        ');
        $time = time();
        $statement->execute([
            $login->getID(),
            $login->getKey(),
            $login->getUserID(),
            date('Y-m-d H:i:s', $time),
            date('Y-m-d H:i:s', $time + Login::EXPIRATION_TIME)
        ]);
        //$pin = $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getLoginByKey($login_key): ?Login{
        $statement = $this->database->connect()->prepare('
            SELECT login_id AS login_id,
            login_key AS login_key,
            user_id AS user_id,
            expiry_time <= now() AS expired
            FROM logins
            WHERE login_key = :login_key;
        ');
        $statement->bindParam(':login_key', $login_key, PDO::PARAM_STR);
        $statement->execute();

        $login = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$login) {
            return null;
        }

        return new Login(
            $login["login_id"],
            $login["login_key"],
            $login["user_id"],
            $login["expired"]
        );
    }

    public function refresh($login_id){
        $statement = $this->database->connect()->prepare('
            UPDATE logins
            SET expiry_time = NOW() + interval \'300 second\'
            WHERE login_id = :login_id;
        ');
        $statement->bindParam(':login_id', $login_id, PDO::PARAM_STR);
        $statement->execute();
    }
}