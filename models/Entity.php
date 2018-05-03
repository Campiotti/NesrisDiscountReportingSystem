<?php

namespace models;
//use services\DBConnection;
use ReflectionClass;
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
    //protected $properties= [];
    protected $tableName;
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
        $r = new ReflectionClass($this);
        $this->tableName=$r->getShortName();
    }

    public function isValid():bool
    {
        return $this->validator->validate();
    }


    protected function defaultValidationConfiguration(){

    }

    /*protected function addProperty($propertyName){
        if(!array_search($propertyName,$this->properties))
            if(property_exists($this,$propertyName))
                array_push($this->properties,$propertyName);
    }*/

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
                $this->valuesSet[$key] = $key;
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
        $this->queryBuilder->setMode(2)
            ->setColsWithValues($this->tableName,$this->valuesSet,$this->getValues())
            ->executeStatement();
    }

    public function update(){
        if($this->id==null)
            return;
        $this->queryBuilder->setMode(1)->setTable($this->tableName)
            ->setColsWithValues($this->tableName,$this->valuesSet,$this->getValues())
            ->addCond($this->tableName,"id",0,$this->id,0)
            ->executeStatement();

    }

    public function deleteOC(){
        if($this->id==null)
            return;
        $this->queryBuilder->setMode(3)->setTable($this->tableName)
            ->addCond($this->tableName,"id",0,$this->id,0)
            ->executeStatement();
    }
    public function delete($id){
        if($id==null)
            return;
        $this->queryBuilder->setMode(3)->setTable($this->tableName)
            ->addCond($this->tableName,"id",0,$id,0)
            ->executeStatement();
    }
    public function viewOC(){
        if ($this->id==null)
            return;
        $query=$this->queryBuilder->setMode(0)->setTable($this->tableName);
        if(count($this->valuesSet)>1)
            $query->setCols($this->tableName,$this->valuesSet);
        $query->addCond($this->tableName,"id",0,$this->id,0);
        //var_dump($query->executeStatement());
        $res = $query->executeStatement();
        $this->patchEntity($res[0]);
    }
    public function view($id){
        if ($id==null)
            return;
        $query=$this->queryBuilder->setMode(0)->setTable($this->tableName);
        if(count($this->valuesSet)>0)
            $query->setCols($this->tableName,$this->valuesSet);
        $query->addCond($this->tableName,"id",0,$id,0);
        $res = $query->executeStatement();
        $this->patchEntity($res[0]);
    }

    public function getId(){
        return$this->id;
    }

}
