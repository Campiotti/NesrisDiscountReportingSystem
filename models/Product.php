<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 27.01.2018
 * Time: 15:17
 */

namespace models;


class Product extends Entity
{
    protected $id;
    public $userfk;
    public $productname;
    public $description;
    public $image;
    public $video;
    public $rating;
    public $views;






    protected function defaultValidationConfiguration()
    {
        //parent::defaultValidationConfiguration();
        $this->validator->isRequired('productname');
        //$this->validator->isRequired('price');
        $this->validator->isRequired('userfk');
        //$this->validator->isRequired('stock');
        $this->validator->minLength('productname',1);
        $this->validator->maxLength('productname',33);
        $this->validator->isRequired("description");
        $this->validator->isRequired('video');
    }


    public function save()
    {
        return$this->queryBuilder->setMode(2)->setColsWithValues("product",array('id','dbuserfk','Productname','Image','Video','Views','Description'),array('',$this->userfk,$this->productname,$this->image,$this->video,0,$this->description))->executeStatement();
    }

    /**
     * @return int ID
     */
    public function getId()
    {
        return $this->id;
    }

    public function edit(int $id){
        if($this->id!=$id){
            echo"invalid edit!";
            die();
        }

        $this->queryBuilder->setMode(1)
            ->setColsWithValues('product',array('productname','image','video','description'),
                array($this->productname,$this->image,$this->video,$this->description))
            ->addCond('product','id',0,$id,true)
            ->addCond('product','dbuserfk',0,$this->userfk,true)
            ->executeStatement();
    }



}