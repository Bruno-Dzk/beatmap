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
        if(!isset($_POST['email'])||!isset($_POST['password'])){
            return $this->render('login', ['messages' => ['Please enter email and password.']]);
        }

        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->userRepository->getUserByEmail($email);

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

        $email = $_POST['email'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repeatedPassword = $_POST['repeatedPassword'];
        $messages = [];

        if($email === "" || $username === "" || $password === "" || $repeatedPassword === ""){
            $messages[] = 'Some of the required fields are empty.';
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $messages[] = 'Email is invalid.';
        }

        if ($password !== $repeatedPassword) {
            $messages[] = 'Passwords do not match.';
        }

        if($this->userRepository->getUserByUsername($username)){
            $messages[] = 'User with this username already exists.';
        }

        if($this->userRepository->getUserByEmail($email)){
            $messages[] = 'User with this email already exists.';
        }

        if($messages){
            return $this->render('register', ['messages' => $messages]);
        }

        // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        //     // invalid emailaddress
        // }

        $user = new User(uniqid("user"), $email, $username, password_hash($password, PASSWORD_BCRYPT));
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

    public function logout(){
        if(isset($_COOKIE["login_cookie"])){
            unset($_COOKIE['login_cookie']); 
        }
        $this->loginRepository->expireLogin($this->currentLogin->getID());
        $url = "http://$_SERVER[HTTP_HOST]";
        header("Location: {$url}/login");
    }

    public function relog(){
        return $this->render('login', ['messages' => ['You have been logged out of the application.']]);
    }
}

