<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 25.10.2017
 * Time: 11:30
 */

namespace controller;


interface ControllerInterface
{
    public function index();
    public function add();
    public function view(int $id);
    public function delete(int $id);
    public function edit(int $id);
}