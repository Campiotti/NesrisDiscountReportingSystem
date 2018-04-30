<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.10.2017
 * Time: 09:35
 */

namespace controller;


class HttpHandler
{

    public function isPost(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return true;
        } else {
            return false;
        }
    }

    public function isGet(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return true;
        } else {
            return false;
        }
    }

    public function getData()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            return $_POST;
        } else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            return $_GET;
        }
    }

    public function redirect(string $controller, string $action)
    {
        header("Location: http://" . $_SERVER['SERVER_NAME'] . "/" . $controller . "/" . $action);
    }

}