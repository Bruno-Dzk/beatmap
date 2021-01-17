<?php

require_once "src/models/Login.php";
require_once "src/models/User.php";
require_once "AppController.php";
require_once "src/repository/UserRepository.php";
require_once "src/repository/LoginRepository.php";

class SecurityController extends AppController{
    private $userRepository;
    private $loginRepository;

    public function __construct(){
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->loginRepository = new LoginRepository();
    }

    private function getLoginData(){
        if (!isset($_COOKIE['login_cookie'])){
            return false;
        }
        $vars = explode(":", $_COOKIE['login_cookie']);
        $username = $vars[0];
        $key = $vars[1];
        $user = $this->userRepository->getUserByUsername($username);
        $login = $this->loginRepository->getLoginByKey($key);
        return ["user" => $user, "login" => $login];
    }

    static private function checkLoginData($loginData){
        if($loginData["login"] === null){
            return false;
        }
        if($loginData["login"]->getUserID() != $loginData["user"]->getID()){
            return false;
        }
        if($loginData["login"]->hasExpired()){
            return false;
        }
        return true;
    }

    public function authorize(){
        $loginData = $this->getLoginData();
        return SecurityController::checkLoginData($loginData);
    }

    public function login(){
        if($this->request !== 'POST'){
            return $this->render('login');
        }
        $username = $_POST['username'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUserByUsername($username);

        if (!$user) {
            return $this->render('login', ['messages' => ['User not found!']]);
        }

        if (!password_verify($password, $user->getPassword())) {
            return $this->render('login', ['messages' => ['Wrong password!']]);
        }

        $login = Login::generateNew($user->getID());
        $this->loginRepository->addLogin($login);
        setcookie("login_cookie",$user->getUsername().":".$login->getKey());

        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}");
    }

    public function refresh(){
        $loginData = $this->getLoginData();
        var_dump(SecurityController::checkLoginData($loginData));
        if(SecurityController::checkLoginData($loginData)){
            $login = $loginData['login']->getID();
            $this->loginRepository->refresh($login);
        }else{
            http_response_code(401);
            die("Cannot refresh login!");
        }
    }
}

