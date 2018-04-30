<?php

include 'Route.php';
require("Autoloader.php");

function debug($var)
{
    /*echo "<pre>";
    print_r($var);
    echo "</pre>";*/
}

$route = new Route();

$route->submit();