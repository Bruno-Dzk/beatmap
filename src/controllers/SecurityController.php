<?php

require_once "src/models/Login.php";
require_once "src/models/User.php";
require_once "AppController.php";
require_once "src/repository/UserRepository.php";
require_once "src/repository/LoginRepository.php";

class SecurityController extends AppController{
    private $userRepository;
    private $loginRepository;
    private $currentUser = null;
    private $currentLogin = null;

    public function __construct(){
        parent::__construct();
        $this->userRepository = new UserRepository();
        $this->loginRepository = new LoginRepository();
        $this->loadLoginCookie();
    }

    private function loadLoginCookie(){
        if (!isset($_COOKIE['login_cookie'])){
            return;
        }
        $vars = explode(":", $_COOKIE['login_cookie']);
        $username = $vars[0];
        $key = $vars[1];
        $this->currentUser = $this->userRepository->getUserByUsername($username);
        $this->currentLogin = $this->loginRepository->getLoginByKey($key);
    }

    public function authorize(){
        if($this->currentUser === null || $this->currentLogin === null){
            return false;
        }
        if($this->currentLogin->getUserID() != $this->currentUser->getID()){
            return false;
        }
        if($this->currentLogin->hasExpired()){
            return false;
        }
        return true;
    }

    public function getLoggedUser(){
        if($this->authorize()){
            return $this->currentUser;
        }
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

    public function register(){
        if($this->request !== 'POST'){
            return $this->render('register');
        }

        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeatedPassword = $_POST['repeatedPassword'];

        if($username === "" || $password === "" || $repeatedPassword === ""){
            die('Some required fields were empty strings.');
        }

        if ($password !== $repeatedPassword) {
            return $this->render('register', ['messages' => ['Passwords do not match.']]);
        }

        $user = new User(uniqid("user"), $username, password_hash($password, PASSWORD_BCRYPT));
        $this->userRepository->addUser($user);
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
    }

    public function refresh(){
        if($this->authorize()){
            $this->loginRepository->refresh($this->currentLogin->getID());
        }else{
            http_response_code(401);
            die("Could not refresh login!");
        }
    }
}

