<?php
/**
 * Created by PhpStorm.
 * User: vmadmin
 * Date: 19.12.2017
 * Time: 14:28
 */

namespace services;


class SessionManager
{

    /**
     * this method starts a new session if there isn't one active already
     */
    public function startSession(){
        if (session_status() != PHP_SESSION_ACTIVE){
            session_start();
        }

    }

    /**
     * in here we can create a new array in the session
     * if it already exists it will be overwritten
     * @param string $key
     * @param array $values
     */
    public function setSessionArray(string $key, array $values){
        if ($values) {
            $_SESSION[$key] = serialize($values);
        }
    }

    /**
     * if the session var exists it will return the whole array unserialized
     * @param string $value
     * @return mixed
     */
    public function getSessionArray(string $value){
        if (isset($_SESSION[$value])){
            return unserialize($_SESSION[$value]);
        }
    }

    /**
     * in here we can set a new session item
     * if it already exists it will be completely overwritten
     * @param string $array
     * @param $key
     * @param $value
     */
    public function setSessionItem(string $array, $key, $value){
        if (isset($_SESSION[$array]) && $value){
            $session = unserialize($_SESSION[$array]);
            $session[$key] = $value;
            $_SESSION[$array] = serialize($session);
        }
    }

    /**
     * in here we can set a new session item
     * this method will NOT overwrite the current content if it exists
     * @param string $array
     * @param $key
     * @param $key2
     * @param $value
     */
    public function addSessionItem(string $array, $key, $key2, $value){
        if (isset($_SESSION[$array]) && $value){
            $session = unserialize($_SESSION[$array]);
            $session[$key][$key2] = $value;
            $_SESSION[$array] = serialize($session);
        }
    }

    /**
     * this method is used to return a session item if its set
     * @param string $array
     * @param $key
     * @return string
     */
    public function getSessionItem(string $array, $key){
        if (isset($_SESSION[$array]) && unserialize($_SESSION[$array])[$key]){
            return unserialize($_SESSION[$array])[$key];
        }
        return"";
    }

    /**
     * this replaces the 'isset($_SESSION[$index])' and makes it easier to write
     * @param $array
     * @return bool
     */
    public function isSet($array){
        if (isset($_SESSION[$array])){
            return true;
        }
    }

    /**
     * this method is used to unset an array set in the session
     * @param $array
     */
    public function unsetSessionArray($array){
        if (isset($_SESSION[$array])){
            unset($_SESSION[$array]);
        }
    }

    /**
     * this method is used to create a new cookie
     * @param $name
     * @param $value
     * @param int $duration
     */
    public function setCookie($name, $value, $duration = 3600){
        $dur = time() + $duration;
        setcookie($name,$value,$dur);
    }

    /**
     * this method is used to receive a set cookie
     * @param $name
     * @return mixed
     */
    public function getCookie($name){
        if (isset($_COOKIE[$name])) {
            return$_COOKIE[$name];
        }
    }

}