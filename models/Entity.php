<?php

namespace models;
//use services\DBConnection;
use services\DBConnection;
use services\QueryBuilder;
use services\SessionManager;


/**
 * Created by PhpStorm.
 * User: Danis
 * Date: 19.10.2017
 * Time: 17:16
 */
class Entity
{

    protected $validator;
    protected $valuesSet = [];
    protected $dbConnection;
    protected $queryBuilder;
    protected $sessionManager;

    /**
     * Entity constructor.
     * @ param $validator
     */
    public function  __construct()
    {
        $this->validator = new Validator($this);
        $this->defaultValidationConfiguration();
        $this->dbConnection = DBConnection::getDbConnection();
        $this->queryBuilder = new QueryBuilder();
        $this->sessionManager= new SessionManager();
    }

    public function isValid():bool
    {
        return $this->validator->validate();
    }


    protected function defaultValidationConfiguration(){

    }


    public function patchEntity($values){
        foreach ($values as $key => $value){
            if(property_exists($this, $key)){
                $this->valuesSet[] = $key;
                $this->$key = $value;
            }
        }
    }

    public function clearEntity(){
        foreach ($this->valuesSet as $value){
            $this->$value = null;
        }
    }

    public function save(){

    }

    public function update(){

    }

    public function delete(){

    }

}
