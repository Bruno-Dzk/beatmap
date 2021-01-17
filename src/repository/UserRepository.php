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
            $user["username"],
            'test_email',
            $user["password"]
        );
    }
}