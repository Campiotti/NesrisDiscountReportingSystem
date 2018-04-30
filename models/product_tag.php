<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 30.01.2018
 * Time: 09:36
 */

namespace models;


class product_tag extends Entity
{
    private $id;
    public $tagid;
    public $productid;






    protected function defaultValidationConfiguration()
    {
        //parent::defaultValidationConfiguration();
        $this->validator->isRequired('tagid');
        $this->validator->isRequired('productid');

    }


    public function save()
    {
        return$this->queryBuilder->setMode(2)->setColsWithValues("product_tag" ,array('id','tagsfk', 'productfk'),array('',$this->tagid, $this->productid))->executeStatement();
    }

}