<?php

require_once "SecurityController.php";

class AppSecureController extends AppController{
    protected $securityController;

    public function __construct()
    {
        parent::__construct();
        $this->securityController = new SecurityController(); 
    }

    protected function authorizeRender(){
        if(!$this->securityController->authorize()){
            $url = "http://$_SERVER[HTTP_HOST]";
            header("Location: {$url}/login");
        }
    }

    protected function authorize(){
        if(!$this->securityController->authorize()){
            http_response_code(401);
            die("Unauthorized access.");
        }
    }
}