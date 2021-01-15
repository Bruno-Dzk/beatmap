<?php

class DefaultController{
    public function index(){
        readfile("public/index.html");
    }

    public function test(){
        session_start();
        var_dump($_SESSION['test']);
    }
}