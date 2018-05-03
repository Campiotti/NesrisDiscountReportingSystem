<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 02.05.2018
 * Time: 08:40
 */

namespace controller;


use models\Report;

class ReportController extends BaseController implements ControllerInterface
{

    public function index()
    {
        // TODO: Implement index() method.
    }

    public function add()
    {
        if($this->httpHandler->isPost() && $this->renderer->sessionManager->isSet('User')){
            $report = new Report();
            $data = $this->httpHandler->getData();
            $data['employeeFk']=$this->renderer->sessionManager->getSessionItem('User','id');
            $data['status']=1;
            $report->patchEntity($data);
            $report->save();
            $this->createAlert('Report submitted','Your report was added to the Database.',true);
        }
        else
            $this->createAlert('Invalid Report','contents invalid',0);
        $this->httpHandler->redirect('user','user');
    }

    public function view(int $id)
    {
        $report = new Report();
        $report->view($id);
        $this->renderer->setAttribute('report',$report);

    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
    }

    public function edit(int $id)
    {
        // TODO: Implement edit() method.
    }
    public function submit(){
        $this->renderer->headerIndex=6;
        $customer=$this->renderer->queryBuilder->setMode(0)->setTable('Customer')
            ->setCols('Customer',array('id','firstname','lastname'))
            ->executeStatement();
        $this->renderer->setAttribute('customer',$customer);

    }
    public function update(int $id){

    }
    
}