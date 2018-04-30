<?php

namespace models;
use services\QueryBuilder;

/**
 * Created by PhpStorm.
 * User: Danis
 * Date: 19.10.2017
 * Time: 17:16
 */
class User extends Entity
{
    protected $id;
    public $email;
    public $username;
    public $password;
    public $endDate;

    public static function getSalt(){
        return '$5$rounds=5000$NesriniDMagician';
    }

    protected function defaultValidationConfiguration()
    {
        //parent::defaultValidationConfiguration();
        $this->validator->isRequired('username');
        $this->validator->isMail('email');
        $this->validator->minLength('username',1);
        $this->validator->maxLength('username',16);
        $this->validator->minLength('password',6);
    }


    public function save()
    {
            $this->queryBuilder->setMode(2)
                ->setColsWithValues('DBUser', array('id', 'email', 'username', 'password', 'enddate'),
                    array('', $this->email, $this->username, crypt($this->password,self::getSalt()), date("Y-m-d H:i:s")))
                ->executeStatement();
    }

    public function edit(int $id){
            $this->queryBuilder->setMode(1)
                ->setColsWithValues('DBUser',array('email','username','password'),
                    array($this->email,$this->username,$this->password))
                ->addCond('DBuser','id',0,$this->id,0)
                ->executeStatement();
    }


}