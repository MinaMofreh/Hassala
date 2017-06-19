<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Person
 *
 * @author root
 */
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');
include_once dirname(dirname(__FILE__)).DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'user_queries.php';
class Person {

    public $userName;
    public $password;
    public $db;

    public function __construct() {
    }

    public function set_username($str) {
        $this->userName = $str;
    }

    public function set_password($str) {
        $this->password = $str;
    }

    public function get_username() {
        return $this->userName;
    }

    public function get_password() {
        return $this->password;
    }

    public function get_username_password($username, $password) {
       $user_query = new user_queries();
       $result = $user_query->retrieve_username_password($username, $password);
       return $result;
    }

}
