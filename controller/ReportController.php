<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 02.05.2018
 * Time: 08:40
 */

namespace controller;


use models\Customer;
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
        $activities=$this->renderer->queryBuilder->setMode(0)->setTable('ReportActivity')
            ->joinTable('Report','ReportActivity',0,'activityFk')
            ->addCond('ReportActivity','reportFk',0,$id,0)
            ->setCols('Activity',array('name'))
            ->setCols('ReportActivity',array('hours','description','doneOn','hours*hourlyPrice as cost'))
            ->executeStatement();
        $this->renderer->setAttribute('activities',$activities);
        $expenses=$this->renderer->queryBuilder->setMode(0)->setTable('ReportExpense')
            ->addCond('ReportExpense','id',0,$id,0)
            ->joinTable('Expense','ReportExpense',0,'expenseFk')
            ->setCols('Expense',array('unitType','unit','unitPrice'))
            ->setCols('ReportExpense',array('amount', 'amount*unitPrice as cost'))
            ->executeStatement();
        $this->renderer->setAttribute('expenses',$expenses);

    }

    public function delete(int $id)
    {
        if($this->renderer->sessionManager->isSet('User')){
            $this->renderer->queryBuilder->setTable('Report')
                ->setMode(3)
                ->addCond('Report',"id",0,$id,true)
                ->addCond('Report','employeeFk',0,$this->renderer->sessionManager->getSessionItem('User','id'),true)
                ->executeStatement();
            $this->createAlert('Deleted Report nr. '.$id,'successful deletion',true);
        }
        $this->httpHandler->redirect('user','user');
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
    public function customerView(int $id){
        $customer= new Customer();
        $customer->view($id);
        $reports=$this->renderer->queryBuilder->setMode(0)
            ->setTable('Report')
            ->setCols('Report',array('id','title,customerFk'))
            ->setCols('Employee',array('id as eid','firstname','lastname'))
            ->addCond('Report','customerFk',0,$id,true)
            ->joinTable('Employee','Report',0,'employeeFk')
            ->executeStatement();
        $this->renderer->setAttribute('reports',$reports);
        $this->renderer->setAttribute('customer',$customer);
    }

}