<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 30.04.2018
 * Time: 11:08
 */

namespace models;


class Report extends Entity
{
    public $customerFk;
    public $employeeFk;
    public $title;
    public $status=1;
    public $signature=null;
    public $signaturedate=null;




}