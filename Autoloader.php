<?php

/**
 * Created by PhpStorm.
 * User: Danis
 * Date: 19.10.2017
 * Time: 17:18
 */

spl_autoload_register(function ($name) {
    $fileName = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $name) . '.php';


    if (file_exists($fileName)) {
        require_once $fileName;
    }
});


