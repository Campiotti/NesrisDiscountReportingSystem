<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 26.10.2017
 * Time: 11:32
 */

namespace services;

/**
 * singleton architecture to prevent multiple connections to exist at the same time
 * Class DBConnection
 * @package services
 */
class DBConnection
{

    private static $dbConnection;

    public static function getDbConnection(){
        if(DBConnection::$dbConnection){
            return DBConnection::$dbConnection;
        }else{
            DBConnection::createConnection();
            return DBConnection::$dbConnection;
        }
    }

    private static function createConnection(){
		$ini = parse_ini_file('config/database.ini');
        DBConnection::$dbConnection = new \PDO($ini['engine'].':host='.$ini['host'].';dbname='.$ini['database'],$ini['username'],$ini['password']);
    }

}