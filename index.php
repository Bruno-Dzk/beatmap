<?php

require "Routing.php";
require_once "src/controllers/PinController.php";

// $path = trim($_SERVER['REQUEST_URI'], '/');
// $path = parse_url($path, PHP_URL_PATH);

$pc = new PinController();
Router::get('/pin', 'POST', array("PinController", "create_pin"));
Router::get('/pin/:id', 'GET', array("PinController", "get_pin"));
//Router::get('/', 'GET', )
// Router::get('projects', 'DefaultController');
Router::run();