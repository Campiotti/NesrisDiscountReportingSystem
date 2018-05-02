<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 30.04.2018
 * Time: 11:09
 */

namespace models;


class Employee extends Entity
{

    public $firstname;
    public $lastname;
    public $email;
    public $tel;
    public $username;
    public $password;

    public static function getSalt(){
        return '$5$rounds=5000$NesriniDMagician';
    }

    public function save()
    {
        $this->password=crypt($this->password,self::getSalt());
        parent::save();
    }
}