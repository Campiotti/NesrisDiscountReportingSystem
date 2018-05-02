<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 16.12.2017
 * Time: 13:34
 */


/**
 *
 * QueryBuilder Tests
 *
 * $qb = new \services\QueryBuilder();
 * var_dump($qb->setMode(0)->setTable('DBUser')->setTable('Profile')->setCols('Profile')->setCols('DBUser', array('id', 'Username', 'Email'))->joinTable('DBUser','Profile', 0, 'DBUserFk')->addCond('DBUser','id',0,'5',false, 0)->addCond('DBUser','Username',1,'Jeff',false, 2)->executeStatement());
 * var_dump($qb->setMode(1)->setColsWithValues('DBUser', array('Username', 'Password'), array('xd', 'Name'))->addCond('DBUser', 'id', 0, '1', false, 0)->executeStatement());
 * var_dump($qb->setMode(2)->setColsWithValues('DBUser', array('id', 'username', 'password', 'email', 'dateofcreation', 'enddate'), array('', 'Username', 'Password', 'email', date("Y-m-d H:i:s"), ''))->executeStatement());
 * var_dump($qb->setMode(3)->setTable('DBUser')->addCond('DBUser', 'id', 0, '2', false, 0)->executeStatement());
*/

namespace services;

/**
 * Fluent API
 * Class QueryBuilder
 * @package services
 * @author        Cedric Schoeni <cedricschoeni123@gmx.ch>
 * @copyright     Copyright (C), 2017-99 Cedric Schoeni
 *
 * @price         100€ for commercial use (for nesri -> 88.-)  (for mesger -> 25.-)
 *
 * @link        http://localhost/bonzivideo/homepage
 */
class QueryBuilder
{
    private $statement = array();
    private $parameters = array();
    private $MODES = array('select', 'update', 'insert', 'delete');
    private $JOINMODES = array('left join', 'right join', 'inner join', 'outer join');
    private $CONDITIONOPERATOR = array('=', '!=', '<', '>', '>=', '<=', 'LIKE', 'IS');
    private $selectedMode = -1;
    private $dbConnection;
    private $limit = -1;
    private $offset = -1;

    /**
     * this sets the mode
     * @param $index
     * @return $this
     */
    public function setMode($index){
        $this->dbConnection = DBConnection::getDbConnection();
        if (!($index > count($this->MODES) || $index < 0 )){
            $this->selectedMode = $index;
        }
        return$this;
    }

    /**
     * in here the table can be set
     * @param $table
     * @return $this
     */
    public function setTable($table) {
        $table = strtolower($table);
        if (!isset($this->statement['Tables'])){
            $this->statement['Tables'][] = $table;
        } else if(!in_array($table, $this->statement['Tables'])){
            $this->statement['Tables'][] = $table;
        }
        return$this;
    }

    /**
     * if the user doesn't want the select statement to return all columns he can filter these with this method
     * @param $table
     * @param array $cols
     * @return $this
     */
    public function setCols($table, array $cols = array()){
        $table = strtolower($table);
        if (count($cols) <= 0){
            $this->statement['Columns'][$table][] = '*';
        } else {
            foreach ($cols as $col)
                $this->statement['Columns'][$table][] = $col;
        }
        return$this;
    }

    /**
     * this is used for insert and update statements
     * @param $table
     * @param array $cols
     * @param array $values
     * @return $this
     */
    public function setColsWithValues($table, array $cols, array $values){
        $this->statement['ColsWVals'] = array('Table' => $table, 'Columns' => $cols, 'Values' => $values);
        return$this;
    }

    /**
     * this method can be used to join tables together
     * on default the joinTable has the id
     * if the foreignTable has the id the swap parameter needs to be set to true
     * @param $joinTable
     * @param $foreignTable
     * @param $index
     * @param $fkCol
     * @param bool $swap
     * @return $this
     */
    public function joinTable($joinTable, $foreignTable, $index, $fkCol, bool $swap = false){
        if (!($index > count($this->JOINMODES) || $index < 0 )){
            $foreignTable = strtolower($foreignTable);
            $joinTable = strtolower($joinTable);
            $this->statement['Joins'][$this->JOINMODES[$index]][$joinTable][] =  $foreignTable."|".$fkCol."|".$swap;
        }
        return$this;
    }

    /**
     * this is used to set a where condition
     * @param $table
     * @param $col
     * @param $index
     * @param $cond
     * @param $andOr
     * @return $this
     */
    public function addCond($table, $col, $index, $cond, $andOr){
        if (!($index > count($this->CONDITIONOPERATOR) || $index < 0 )) {
            $table = strtolower($table);

            $this->statement['Conditions'][] = array('Table' => $table, 'Column' => $col, 'Operator' => (($index > 5) ? ' ' : '').$this->CONDITIONOPERATOR[$index], 'Condition' => $cond, 'ConnectionMode' => (($andOr) ? 'and' : 'or'));
        }
        return$this;
    }

    /**
     * here a limit and offset can be set
     * @param int $limit
     * @param int $offset
     * @return $this
     */
    public function limitOffset(int $limit, int $offset = 0){
        $this->limit = $limit;
        $this->offset = $offset;

        return$this;
    }

    /**
     * here the result can be ordered by cols
     * this method needs to which table the column goes
     * to use it orderBy(array('table.column', ...));
     * @param array $cols
     * @return $this
     */
    public function orderBy(array $cols){
        foreach($cols as $col){
            $this->statement['Order'][] = $col;
        }
        return$this;
    }

    /**
     * here the result can be grouped by cols
     * this method needs to which table the column goes
     * to use it orderBy(array('table.column', ...));
     * @param array $cols
     * @return $this
     */
    public function groupBy(array $cols){
        foreach($cols as $col){
            $this->statement['Group'][] = $col;
        }
        return$this;
    }

    /**
     * this method creates a select statement
     * @return string
     */
    private function createSelectStatement(){
        $statement = "select ";

        if(isset($this->statement['Columns'])){
            $string = "";
            foreach($this->statement['Columns'] as  $key => $value){
                foreach($value as $cols){
                    if ($cols != "*")
                        $string .= $key.".".$cols.",";
                }
            }
            $statement .= substr($string, 0, -1);
        } else {
            $statement .= "*";
        }

        $statement .= " from ";

        if (isset($this->statement['Tables'])){
            $statement .= $this->statement['Tables'][0]." ";
        }

        if (isset($this->statement['Joins'])){
            $string = "";
            foreach($this->statement['Joins'] as  $key => $value) {
                foreach($value as $ptkey => $pt){
                    foreach($pt as $val){
                        $vals = explode('|', $val);
                        if (!$vals[2]){
                            $string .= $key." ".$ptkey." on ".$ptkey.".id=".$vals[0].".".$vals[1]." ";
                        } else {
                            $string .= $key." ".$ptkey." on ".$ptkey.".".$vals[1]."=".$vals[0].".id ";
                        }
                    }
                }
            }
            $statement .= $string;
        }

        if (isset($this->statement['Conditions'])){
            $string = "where ";
            $start = true;
            foreach($this->statement['Conditions'] as $conditions){
                $this->parameters[] = $conditions['Condition'];
                if ($start){
                    $string .= $conditions['Table'].".".$conditions['Column'].$conditions["Operator"]."?";
                    $start = false;
                    continue;
                }
                $string .= " ".$conditions['ConnectionMode']." ".$conditions['Table'].".".$conditions['Column'].$conditions["Operator"]."?";

            }
            $statement .= $string;
        }

        if (isset($this->statement['Group'])){
            $string = "";
            foreach($this->statement['Group'] as $order){
                $string .= $order.",";
            }
            $statement .= " group by ".substr($string, 0, -1);
        }

        if (isset($this->statement['Order'])){
            $string = "";
            foreach($this->statement['Order'] as $order){
                $string .= $order.",";
            }
            $statement .= " order by ".substr($string, 0, -1);
            //Added custom, forces descending upon all order by
            //$statement.=" desc";
        }

        if ($this->limit > 0 ){
            $statement .= " limit ".$this->limit." offset ".$this->offset;
        }



        return$statement.";";
    }
    /**
     * this method creates an update statement
     * @return string
     */
    private function createUpdateStatement(){
        $statement = "update ";

        if (isset($this->statement['ColsWVals']) && count($this->statement['ColsWVals']['Values']) == count($this->statement['ColsWVals']['Columns'])){
            $statement .= $this->statement['ColsWVals']['Table'];
            $statement .= " set ";
            $tmpI=0;
            foreach($this->statement['ColsWVals']['Columns'] as $colsWVal){
                $this->parameters[] = $this->statement['ColsWVals']['Values'][$tmpI];
                $statement .= $colsWVal.="=?,";
                $tmpI++;
            }

            /*for($i = 0;$i < count($this->statement['ColsWVals']['Columns']); $i++) {
                $this->parameters[] = $this->statement['ColsWVals']['Values'][$i];
                $statement .= $this->statement['ColsWVals']['Columns'][$i]."=?,";
            }*/
            $statement = substr($statement, 0, -1);
        }

        if (isset($this->statement['Conditions'])){
            $string = " where ";
            $start = true;
            foreach($this->statement['Conditions'] as $conditions){
                $this->parameters[] = $conditions['Condition'];
                if ($start){
                    $string .= $conditions['Table'].".".$conditions['Column'].$conditions["Operator"]."?";
                    $start = false;
                    continue;
                }
                $string .= " ".$conditions['ConnectionMode']." ".$conditions['Table'].".".$conditions['Column'].$conditions["Operator"]."?";

            }
            $statement .= $string;
        }
        return$statement.";";
    }
    /**
     * this method creates an insert statement
     * @return string
     */
    public function createInsertStatement(){
        $statement = "insert into ";

        if (isset($this->statement['ColsWVals']) && count($this->statement['ColsWVals']['Values']) == count($this->statement['ColsWVals']['Columns'])){
            $statement .= $this->statement['ColsWVals']['Table']." (";
            foreach($this->statement['ColsWVals']['Columns'] as $cols){
                $statement .= $cols.",";
            }
            $statement = substr($statement, 0, -1).") values (";
            foreach($this->statement['ColsWVals']['Values'] as $vals){
                $this->parameters[] = $vals;
                $statement .= "?,";
            }
            $statement = substr($statement, 0, -1).")";
        }
        return$statement.";";
    }

    /**
     * this method creates a delete statement
     * @return string
     */
    private function createDeleteStatement(){
        $statement = "delete from ";

        if (isset($this->statement['Tables'])){
            $statement .= $this->statement['Tables'][0]." ";
        }

        if (isset($this->statement['Conditions'])){
            $string = "where ";
            $start = true;
            foreach($this->statement['Conditions'] as $conditions){
                $this->parameters[] = $conditions['Condition'];
                if ($start){
                    $string .= $conditions['Table'].".".$conditions['Column'].$conditions["Operator"]."?";
                    $start = false;
                    continue;
                }
                $string .= " ".$conditions['ConnectionMode']." ".$conditions['Table'].".".$conditions['Column'].$conditions["Operator"]."?";

            }
            $statement .= $string;
        }
        return$statement.";";
    }

    /**
     * this method will bind all parameters to the statement
     * this will prevent any SQL Injections from happening it also prevents any XSS Attacks from happening
     * if its an insert statement it will automatically return the last inserted it
     * @return mixed
     */
    public function executeStatement(){
        $stmt = $this->getStatement();
        $statement = $this->dbConnection->prepare($stmt);
        foreach($this->parameters as $key => $param){
            $statement->bindValue(($key+1), htmlspecialchars($param, ENT_QUOTES));
            //echo$param.'<br>';
        }
        //var_dump($stmt);
        //var_dump($statement);
        $statement->execute();
        if ($this->selectedMode == 2){
            $result = $this->dbConnection->lastInsertId();
        } else {
            $result = $statement->fetchAll();
        }
        $this->reset();
        return$result;
    }

    /**
     * this method calls the needed method to create the statement depending on the chosen mode
     * @return string
     */
    public function getStatement(){
        $statement = "";
        switch($this->selectedMode) {
            case 0:
                $statement = $this->createSelectStatement();
                break;
            case 1:
                $statement = $this->createUpdateStatement();
                break;
            case 2:
                $statement = $this->createInsertStatement();
                break;
            case 3:
                $statement = $this->createDeleteStatement();
                break;
            default:

                break;
        }
        return$statement;
    }

    /**
     * this method is for debug purpose only
     * @return array
     */
    public function getStatementArray(){
        return$this->statement;
    }

    /**
     * after executing a statement everything is set to default
     */
    private function reset(){
        $this->selectedMode = -1;
        $this->limit = -1;
        $this->offset = -1;
        $this->statement = array();
        $this->parameters = array();
    }
}