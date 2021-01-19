<?php

require_once "AppSecureController.php";

class DefaultController extends AppSecureController{
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->authorizeRender();
        return $this->render('index');
    }
}