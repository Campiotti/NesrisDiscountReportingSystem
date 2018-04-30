<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 14.03.2018
 * Time: 20:42
 */

namespace models;


class Favourite extends Entity
{
    private $id;
    public $userfk;
    public $productfk;

    protected function defaultValidationConfiguration()
    {
        $this->validator->isRequired('userfk');
        $this->validator->isRequired('productfk');
    }

    public function save()
    {
        if($this->isValid()){
            /*$check = $this->queryBuilder->setMode(0)
                ->setTable('favourite')
                ->setCols('favourite',array('id','userfk','productfk'))
                ->addCond('favourite','userfk',0,$this->userfk,false)
                ->addCond('favourite','productfk',0,$this->productfk,false)
                ->executeStatement()[0]['id'];
            if($check>0)*/
                $this->queryBuilder->setMode(2)
                    ->setColsWithValues('favourite',array('id','userfk','productfk'),array(null,$this->userfk,$this->productfk))
                    ->executeStatement();
        }
    }

    public function delete()
    {
        if($this->isValid())
        echo$this->queryBuilder->setMode(3)
            ->setTable('favourite')
            ->addCond('favourite','userfk',0,$this->userfk,true)
            ->addCond('favourite','productfk',0,$this->productfk,true)
            ->executeStatement();
    }

    public function change(){
        if($this->isValid()){
            $check = $this->queryBuilder->setMode(0)
                ->setTable('favourite')
                ->setCols('favourite',array('id','userfk','productfk'))
                ->addCond('favourite','userfk',0,$this->userfk,true)
                ->addCond('favourite','productfk',0,$this->productfk,true)
                ->executeStatement();
            if(count($check)==0){
                $this->save();
                return "saved";
            }
            else
                $this->delete();
        }
        return"deleted";
    }

}