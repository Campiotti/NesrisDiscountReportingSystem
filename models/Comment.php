<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 17.12.2017
 * Time: 18:01
 */

namespace models;


class Comment extends Entity
{

    public $id;
    public $userFk;
    public $blogFk;
    public $content;

    protected function defaultValidationConfiguration()
    {

        $this->validator->isRequired('content');
    }

}