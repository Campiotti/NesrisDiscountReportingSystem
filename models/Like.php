<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 17.12.2017
 * Time: 18:02
 */

namespace models;


class Like extends Entity
{
    private $id;
    public $DBUserFK;
    public $BlogFK;

    public function seedSave(){
        $this->queryBuilder->setMode("insert")
            ->setIntoTable("DBLike")
            ->setColumns(array("DBUserFK","BlogFK"))
            ->addInsertValueSet(array($this->DBUserFK,$this->BlogFK))
            ->executeStatement();
    }
}