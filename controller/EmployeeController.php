<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 02.05.2018
 * Time: 12:00
 */

namespace controller;


use models\Employee;

class EmployeeController extends BaseController implements ControllerInterface
{

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function add()
    {
        // TODO: Implement add() method.
    }

    public function view(int $id)
    {
        // TODO: Implement view() method.
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function edit(int $id)
    {
        // TODO: Implement edit() method.
    }
    public function user(){
        if($this->renderer->sessionManager->isSet('User')){
            $emp = new Employee();
            $emp->patchEntity(array('id'=>$this->renderer->sessionManager->getSessionItem('User','id')));
            $emp->view();
            $this->renderer->setAttribute('user',$emp);
        }
    }

}