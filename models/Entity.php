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
    protected $id;
    protected $validator;
    protected $valuesSet = [];
    protected $properties= [];
    protected $tablename;
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

    protected function addProperty($propertyName){
        if(!array_search($propertyName,$this->properties))
            if(property_exists($this,$propertyName))
                array_push($this->properties,$propertyName);
    }

    protected function getValues(){
        $tmp = [];
        foreach($this->valuesSet as $value)
            if(property_exists($this,$value))
                array_push($tmp,$this->$value);
        return $tmp;
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
        $this->queryBuilder->setMode(2)->setTable($this->tablename)
            ->setColsWithValues($this->tablename,$this->valuesSet,$this->getValues())
            ->executeStatement();
    }

    public function update(){
        $id="id";
        $this->queryBuilder->setMode(1)->setTable($this->tablename)
            ->setColsWithValues($this->tablename,$this->valuesSet,$this->getValues())
            ->addCond($this->tablename,"id",0,$this->$id,0)
            ->executeStatement();

    }

    public function delete(){
        $id="id";
        $this->queryBuilder->setMode(3)->setTable($this->tablename)
            ->addCond($this->tablename,"id",0,$this->$id,0)
            ->executeStatement();
    }

}
