<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
//Require autoload
require_once ('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Turn of Fat-Free error reporting
$f3->set('DEBUG', 3);

//Define a route with a one parameter
$f3->route('GET /@type', function($f3, $params) {
    print_r($params);
    if($params[0] == "/chicken") {
        echo("<h1>Cluck!</h1>");
    }

    else if($params[0] == "/dog") {
        echo("<h1>Woof!</h1>");
    }

    else if($params[0] == "/bear") {
        echo("<h1>Rahhhr!</h1>");
    }

    else if($params[0] == "/cat") {
        echo("<h1>Meaw!</h1>");
    }

    else if($params[0] == "/lion") {
        echo("<h1>Rowhr!</h1>");
    }

    else {
        $f3->error(404);
    }


});

//Define a default route
$f3->route('GET /', function() {
    echo '<h1>My Pets</h1>';
    echo '<a href="order">Order a pet</a>';

});

//Order route
$f3->route('GET /order', function() {
    $view = new View;
    echo $view->render('views/form1.html');
});

$f3->route('POST /order2', function() {
    $_SESSION['animal'] = $_POST['animal'];

    print_r($_SESSION);
    $view = new View();
    echo $view->render('views/form2.html');
});

$f3->route('POST /results', function() {
    $_SESSION['color'] = $_POST['color'];
    print_r($_SESSION);
    $template = new Template();
    echo $template->render('views/results.html');
});

//Run fat free
$f3->run();
