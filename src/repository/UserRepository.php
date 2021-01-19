<?php

require_once "Repository.php";
require_once "src/models/User.php";

class UserRepository extends Repository{
    
    public function getUserByUsername($username) : ?User{
        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.app_user WHERE username = :username
        ');
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['app_user_id'],
            $user['email'],
            $user["username"],
            $user["password"],
            $user['verified']
        );
    }

    public function getUserByEmail($email) : ?User{
        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.app_user WHERE email = :email
        ');
        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['app_user_id'],
            $user['email'],
            $user["username"],
            $user["password"],
            $user['verified']
        );
    }

    public function getUserByID($user_id) : ?User{
        $statement = $this->database->connect()->prepare('
            SELECT * FROM public.app_user WHERE app_user_id = :app_user_id
        ');
        $statement->bindParam(':app_user_id', $user_id, PDO::PARAM_STR);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return null;
        }

        return new User(
            $user['app_user_id'],
            $user['email'],
            $user["username"],
            $user["password"],
            $user['verified']
        );
    }

    public function addUser($user){
        $statement = $this->database->connect()->prepare('
            INSERT INTO public.app_user VALUES(?, ?, ?, ?, ?);
        ');
        $statement->execute([
            $user->getID(),
            $user->getUsername(),
            $user->getPassword(),
            $user->isVerified() ? "true" : "false",
            $user->getEmail()
        ]);
    }
}