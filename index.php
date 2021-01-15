<?php

require "Routing.php";
require_once "src/controllers/PinController.php";
require_once "src/controllers/TrackController.php";
require_once "src/controllers/DefaultController.php";

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Router::get('', 'DefaultController');
Router::get('pins', 'PinController');
Router::get('pinsInExtent', 'PinController');
Router::post('addPin', 'PinController');
Router::get('searchTracks', 'TrackController');
Router::get('track', 'TrackController');
// $pc = new PinController();
// Router::get('/pin', 'POST', array("PinController", "createPin"));
// Router::get('/pin/:id', 'GET', array("PinController", "getPin"));
//Router::get('/', 'GET', )
// Router::get('projects', 'DefaultController');
Router::run($path);