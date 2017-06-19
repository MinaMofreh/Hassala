<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once realpath(__DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'initialize.inc.php');

class user_queries {

    private $db;

    public function __construct() {
        $this->db = new DataBase();
    }

    public function retrieve_username_password($username, $password) {
        
        $query = "SELECT `instructor_id`, `student_id`, `user_name`, `password`, `type` FROM `Users` WHERE `user_name` = '$username' AND   `password` = '$password'";
        if ($query_run = $this->db->database_query($query)) {
            if (mysqli_num_rows($query_run) == NULL) {
                return False;
            } else {
                $query_row = $this->db->database_all_assoc($query_run);
                return $query_row[0];
            }
        } else {
            return False;
        }
    }

}
