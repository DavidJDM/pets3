<?php

//Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
//Require autoload
require_once ('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();
$f3->set('colors', array('pink', 'green', 'blue'));

//Turn of Fat-Free error reporting
$f3->set('DEBUG', 3);

require_once ('model/validation-functions.php');

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
$f3->route('GET|POST /order', function($f3) {
        $_SESSION = array();

        if(isset($_POST['animal'])) {

            $animal = $_POST['animal'];
            if(validString($animal)) {
                $_SESSION['animal'] = $animal;
                $f3->reroute('/order2');
            } else {
                $f3->set("errors['animal']", "Please enter an animal.");
            }
        }
        $template = new Template();
        echo $template->render('views/form1.html');
    });

$f3->route('GET|POST /order2', function($f3) {


    print_r($_SESSION);

    if(isset($_POST['color'])) {
        $color = $_POST['color'];

        if(validColor($color)) {
            $_SESSION['color'] = $color;
            $f3->reroute('/results');
        } else {
            $f3->set("errors['color']", "Please enter a color.");
        }
    }
    $template = new Template();
    echo $template->render('views/form2.html');
});

$f3->route('GET|POST /results', function() {
    print_r($_SESSION);
    $template = new Template();
    echo $template->render('views/results.html');
});

//Run fat free
$f3->run();
